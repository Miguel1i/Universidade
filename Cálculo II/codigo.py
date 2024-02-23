from math import pow, fabs
import matplotlib.pyplot as plt
from numpy import linspace, exp, zeros_like

def derivada(abcissa: float) -> float | bool:
    """Esta função permite calcular a derivada da expressão matemática em estudo
    num ponto (abcissa) pela definição de função de derivada.

    Args:
        abcissa (float): Valor da abcissa no qual a derivada é calculada.

    Returns:
        float | bool: O valor da derivada arredondado em 6 casas decimais | Caso
        a função não puder ser diferenciada.
    """
    if abcissa == 0 or abcissa == 3:
        return False
    
    resultado_1 = (exp(1 / ((abcissa + 0.1) ** 2 - 3 * (abcissa + 0.1))) - exp(1 / (abcissa ** 2 - 3 * abcissa))) / 0.1
    resultado_2 = (exp(1 / ((abcissa + 0.01) ** 2 - 3 * (abcissa + 0.01))) - exp(1 / (abcissa ** 2 - 3 * abcissa))) / 0.01

    contador: int = 3

    while fabs(resultado_2 - resultado_1) > 0.0000001:
        proximo_resultado = (exp(1 / ((abcissa + pow(10, -contador)) ** 2 - 3 * (abcissa + pow(10, -contador)))) - exp( 1 / (abcissa ** 2 - 3 * abcissa))) / pow(10, -contador)

        resultado_1 = resultado_2
        resultado_2 = proximo_resultado

        contador += 1

    return round(resultado_2, 6)

def equacaoReta(abcissa: float) -> tuple:
    """Esta função permite calcular a equação da reta tangente à expressão
    matemática num ponto (abcissa).

    Args:
        abcissa (float): Abcissa do ponto que pertence à reta tangente.

    Returns:
        tuple: Declive e Ordenada na origem da reta tangente.
    """
    declive = derivada(abcissa)
    ordenada = exp(1 / (abcissa ** 2 - 3 * abcissa))
    b = round(declive * -abcissa + ordenada, 6)
    return declive, b

def grafico(abcissa: float) -> None:
    """Esta função gera o gráfico da expressão matemática em estudo.

    Args:
        abcissa (float): Abcissa do ponto que pertence à reta tangente.

    Returns:
        None: A função não tem retorno.
    """

    # Valores de x
    x = linspace(abcissa - 10, abcissa + 10, 100)

    # Função
    denominador: float = x ** 2 - 3 * x
    mascara = denominador != 0
    y = zeros_like(x)
    y[mascara] = exp(1 / denominador[mascara])

    # Reta tangente
    declive, b = equacaoReta(abcissa)
    y_reta = declive * x + b

    # Gráfico
    plt.plot(x, y, label='f(x) = e^(1/x^2 - 3x)')
    plt.plot(x, y_reta, label=f't: {declive}x + {b}')
    plt.xlabel('x')
    plt.ylabel('y')
    plt.title('Gráfico da reta tangente de uma função\n')
    plt.legend()
    plt.grid(True)
    plt.show()
    return None


def main() -> None:
    while True:
        while True:
            ans = input('\nIntroduza o valor de x (q - Sair): ' )
            if ans == 'q':
                print('Adeus!')
                quit()
            else:
                try:
                    ans = float(ans)
                    break
                except ValueError:
                    print('O valor introduzido não é um número...\n')
            
        # Verifica se a função é diferenciável. 
        declive = derivada(ans)
        if not declive:
            print(f'Não existe derivada no ponto introduzido!')
        else:
            grafico(ans)

if __name__ == "__main__":
    main()