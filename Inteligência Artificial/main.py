import os
import numpy as np
import librosa
from sklearn.model_selection import train_test_split
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout
from tensorflow.keras.optimizers import Adam
import matplotlib.pyplot as plt
import seaborn as sns
from sklearn.metrics import confusion_matrix, classification_report, precision_recall_curve
from imblearn.over_sampling import SMOTE
from tensorflow.keras.regularizers import l2


def extrair_caracteristicas(caminho_audio: str, duracao: float = 1.0) -> np.array:
    """
    Extrair características de áudio utilizando a biblioteca Librosa.
    :param caminho_audio:  Caminho para o ficheiro de áudio
    :param duracao:  Duração do áudio a ser considerada
    :return:  Array de características extraídas
    """
    y, sr = librosa.load(caminho_audio, duration=duracao)
    mfccs = librosa.feature.mfcc(y=y, sr=sr, n_mfcc=13)
    chroma = librosa.feature.chroma_stft(y=y, sr=sr)
    mel = librosa.feature.melspectrogram(y=y, sr=sr)
    contraste_espectral = librosa.feature.spectral_contrast(y=y, sr=sr)

    # Combinar características estatísticas
    caracteristicas = []
    for feat in [mfccs, chroma, mel, contraste_espectral]:
        caracteristicas.extend([np.mean(feat), np.std(feat), np.max(feat), np.min(feat)])
    print(caracteristicas)
    return np.array(caracteristicas)


def criar_modelo(formato_entrada: int) -> Sequential:
    """
    Criar um modelo de Rede Neural Feedforward.
    :param formato_entrada:  Número de características de entrada
    :return: Modelo de Rede Neural
    """
    modelo = Sequential([
        Dense(128, activation='relu', input_shape=(formato_entrada,), kernel_regularizer=l2(0.01)),
        Dropout(0.4),
        Dense(64, activation='relu', kernel_regularizer=l2(0.01)),
        Dropout(0.3),
        Dense(32, activation='relu', kernel_regularizer=l2(0.01)),
        Dense(1, activation='sigmoid')
    ])
    modelo.compile(
        optimizer=Adam(learning_rate=0.001),
        loss='binary_crossentropy',
        metrics=['accuracy']
    )
    return modelo


def treinar_detector(ficheiros_baleia_golfinho, ficheiros_ambiente) -> (Sequential, np.array, np.array):
    """
    Treinar um detector de som de baleia/golfinho.
    :param ficheiros_baleia_golfinho: Lista de ficheiros de áudio de baleia/golfinho
    :param ficheiros_ambiente: Lista de ficheiros de áudio de ambiente
    :return: Modelo treinado, Conjunto de teste e Etiquetas de teste
    """
    X, y = [], []

    # Extrair características e etiquetas
    for ficheiro in ficheiros_baleia_golfinho:
        X.append(extrair_caracteristicas(ficheiro))
        y.append(1)
    for ficheiro in ficheiros_ambiente:
        X.append(extrair_caracteristicas(ficheiro))
        y.append(0)

    X = np.array(X)
    y = np.array(y)

    # Balancear o conjunto de dados utilizando SMOTE
    smote = SMOTE(random_state=42)
    X, y = smote.fit_resample(X, y)

    # Dividir em conjuntos de treino e teste
    X_treino, X_teste, y_treino, y_teste = train_test_split(X, y, test_size=0.3, random_state=42)

    # Treinar modelo
    modelo = criar_modelo(X_treino.shape[1])
    modelo.fit(X_treino, y_treino, epochs=100, batch_size=32, validation_split=0.2, verbose=1)

    # Avaliar no conjunto de teste
    perda_teste, precisao_teste = modelo.evaluate(X_teste, y_teste)
    print(f"Perda no Teste: {perda_teste}, Precisão no Teste: {precisao_teste}")

    # Optimizar o limiar
    probabilidades = modelo.predict(X_teste).ravel()
    precisao, recall, limiares = precision_recall_curve(y_teste, probabilidades)
    f1_scores = 2 * (precisao * recall) / (precisao + recall)
    indice_otimo = np.argmax(f1_scores)
    limiar_otimo = limiares[indice_otimo]
    print(f"Limiar Óptimo: {limiar_otimo}")

    # Predições com o limiar otimizado
    y_predito = (probabilidades > limiar_otimo).astype("int32")

    # Matriz de Confusão
    matriz_confusao = confusion_matrix(y_teste, y_predito)
    print("\nMatriz de Confusão:")
    print(matriz_confusao)

    # Relatório de Classificação
    relatorio = classification_report(y_teste, y_predito, target_names=["Ambiente", "Baleia/Golfinho"])
    print("\nRelatório de Classificação:")
    print(relatorio)

    # Gráfico da Matriz de Confusão
    plotar_matriz_confusao(matriz_confusao, ["Ambiente", "Baleia/Golfinho"])

    return modelo, X_teste, y_teste


def plotar_matriz_confusao(matriz: confusion_matrix, classes: list) -> None:
    """
    Plotar a matriz de confusão.
    :param matriz: Matriz de confusão
    :param classes: Lista de classes
    :return: None
    """
    plt.figure(figsize=(6, 6))
    sns.heatmap(matriz, annot=True, fmt="d", cmap="Blues", xticklabels=classes, yticklabels=classes)
    plt.ylabel("Valor real")
    plt.xlabel("Valor previsto")
    plt.title("Matriz de Confusão")
    plt.show()

def obter_ficheiros(diretorio: str) -> list:
    """
    Obter todos os ficheiros de um diretório.
    :param diretorio:  Diretório a ser pesquisado
    :return: Lista de caminhos para os ficheiros
    """
    todos_ficheiros = []
    for raiz, pastas, ficheiros in os.walk(diretorio):
        for ficheiro in ficheiros:
            todos_ficheiros.append(os.path.join(raiz, ficheiro))
    return todos_ficheiros


# Script Principal
if __name__ == "__main__":
    # Carregar ficheiros
    ficheiros_baleia_golfinho = obter_ficheiros("sounds/sound")
    ficheiros_ambiente = obter_ficheiros("sounds/ambient")

    # Treinar o modelo
    modelo, X_teste, y_teste = treinar_detector(ficheiros_baleia_golfinho, ficheiros_ambiente)