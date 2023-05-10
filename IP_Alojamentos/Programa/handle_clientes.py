from clientes import Clientes
from cliente import Cliente

clientes = Clientes()


def login():
    # Load dos clientes
    clientes.load_clientes()

    # Verifica se o username for uma string vazia, caso seja volta a pedir para introduzir um username
    while True:
        username = str(input("\nIntroduza o seu username << "))
        if username == "":
            print("\nIntroduza um username válido!\n")
        else:
            break

    user_in_session = {}

    # Percorre pelos ids dos clientes e verifica se o username introduzido corresponde a username de um cliente
    for user_id in clientes.get_clientes():

        if clientes.get_clientes()[user_id]["username"] == username:
            # Adiciona o Cliente ao dicionário user_in_session
            user_in_session.update(clientes.get_clientes()[user_id])

            # Associa o id do Cliente à variável user_id_in_session
            clientes.set_user_id(user_id)

    # Se o dicionário estiver vazio o utilizador volta à função login
    if not user_in_session:
        print("\nUtilizador não encontrado.\n")
        login()
        return None

    # Verifica se a password está correta, caso contrário volta a pedir a password
    while True:
        password = str(input("Introduza a sua password << "))
        if password != user_in_session["password"]:
            print("\nPassword errada!\n")
        else:
            break


def regist_cliente():
    # Verifica caso o nome introduzido for uma string vazia, caso seja volta a pedir para introduzir um nome
    while True:
        name = str(input("\nIntroduza o seu nome << "))
        if name == "":
            print("\nIntroduza um nome válido!\n")
        else:
            break

    # Verifica se o username introduzido for uma string vazia, caso seja volta a pedir para introduzir um username
    while True:
        username = str(input("Introduza um username << "))
        if username == "":
            print("\nIntroduza um username válido!\n")
        else:
            break

    # Lista dos usernames de todos os clientes
    existing_users = [cliente["username"] for cliente in clientes.get_clientes().values()]

    # Verifica se o username encontra-se na lista de utilizadores
    valid_new_user = False
    while not valid_new_user:
        if username in existing_users:
            print("\nUsername já existe.\n")
            username = str(input("Introduza um username << "))
        else:
            valid_new_user = True

    # Verifica se a password introduzida for uma string vazia, caso seja volta a pedir para introduzir uma password
    while True:
        password = str(input("Introduza uma password << "))
        if password == "":
            print("\nIntroduza uma password válida!")
        else:
            break

    # Cria um objeto da classe Cliente com os atributos previamente obtidos
    cliente = Cliente(name, username, password)
    # Adiciona o cliente ao dicionário self.clientes
    clientes.add_cliente(cliente)
    print("*- Registo com Sucesso! -*")


def remove_cliente():
    # Verifica se o id do cliente for um número inteiro, caso contrário volta a pedir para introduzir um id válido
    while True:
        # Print de utilizadores existentes
        list_of_clients()
        try:
            id_cl = int(input("ID do Cliente que pretende remover [0 - Cancelar] << "))
            if id_cl == 0:
                return id_cl
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Verifica se o id do cliente se encontra no dicionário self.clientes, caso contrário volta à função
    if id_cl not in clientes.get_clientes().keys():
        print("\n""Número ID de Cliente inexistente""\n")
        remove_cliente()

    else:
        # Remove o cliente do self.clientes através do id
        clientes.remove_cliente(id_cl)
        print("Cliente removido com Sucesso!")


def change_cliente():

    # Verifica se o id do cliente introduzido é um número inteiro
    while True:
        # Print dos Clientes existentes
        list_of_clients()
        try:
            id_cl = int(input("ID do Cliente que pretende alterar [0 - Cancelar] << "))
            if id_cl == 0:
                return id_cl
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Se o id do cliente não estiver no dicionário self.clientes, o utilizador retorna à função change_cliente
    if id_cl not in clientes.get_clientes().keys():
        print("\n""Número ID de Cliente inexistente""\n")
        change_cliente()

    # Verifica se o novo nome é uma string vazia, caso seja pede um novo nome
    while True:
        new_name = str(input("Introduza um nome novo << "))
        if new_name == "":
            print("\nIntroduza um nome válido!\n")
        else:
            break

    # Verifica se o novo username é uma string vazia, caso seja pede um novo username
    while True:
        new_username = str(input("Introduza um username novo << "))
        if new_username == "":
            print("\nIntroduza um nome válido!\n")
        else:
            break

    # Verifica se a nova password é uma string vazia, caso seja pede uma nova password
    while True:
        new_password = str(input("Introduza uma password nova << "))
        if new_password == "":
            print("\nIntroduza um nome válido!\n")
        else:
            break

    # Cria um objeto da Classe cliente com os novos atributos
    new_cliente = Cliente(new_name, new_username, new_password)
    # Substitui o Cliente a alterar pela informação nova do novo cliente
    clientes.update_cliente(id_cl, new_cliente)
    print("Cliente alterado com Sucesso!")


def consult_cliente_by_id():

    # Verifica se o id do cliente é um número inteiro, caso não seja pede um novo id
    while True:
        # Print dos Clientes existentes
        list_of_clients()
        try:
            id_cl = int(input("ID do Cliente que pretende consultar [0 - Cancelar] << "))
            if id_cl == 0:
                return id_cl
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Se o id do cliente não existir retorna o utilizador à função consult_cliente_by_id
    if id_cl not in clientes.get_clientes().keys():
        print("\n""Número ID de Cliente inexistente""\n")
        consult_cliente_by_id()

    # Caso contrário faz print das informações do Cliente a consultar
    else:
        cliente = clientes.get_clientes()[id_cl]
        name = cliente["name"]
        username = cliente["username"]
        password = cliente["password"]
        print("\n*------------ Cliente ------------*")
        print(f"ID {id_cl}, Nome: {name}, Username: {username}, Password: {password}")
        print("*---------------------------------*\n")


def list_of_clients():
    # Print dos Clientes existentes
    print("\n*------------------ Clientes ------------------*")
    for id_cl, cl in clientes.get_clientes().items():
        name = cl["name"]
        print(f"ID: {id_cl}, Nome: {name}")
    print("*------------------------------------------------*\n")
