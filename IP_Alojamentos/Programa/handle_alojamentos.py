from alojamentos import Alojamentos
from alojamento import Alojamento
from datetime import datetime
from handle_clientes import clientes
import json

alojamentos = Alojamentos()


# adiciona um alojamento
def add_alojamento():
    # Para aceitar um novo alojamento, pedimos ao utilizador para atribuir o nome, o local, a tipologia, e a
    # capacidade máxima:
    while True:
        name = str(input("\nNome do Alojamento << "))
        if name == "":
            print("\nIntroduza um nome válido!")
        else:
            break
    # O nome de cada alojamento tem de ser unico, por isso, iteramos sobre todos os nomes de alojamentos existentes
    # para verificar se o nome já existe  
    for al in alojamentos.dict_of_alojamentos().values():

        if al["name"] == name:
            print("\nAlojamento já existente.\n")
            add_alojamento()

    while True:
        local = str(input("Local do Alojamento << "))
        if local == "":
            print("\nIntroduza um local válido!")
        else:
            break

    while True:
        typology = str(input("Tipologia do Alojamento << "))
        if typology == "":
            print("\nIntroduza uma tipologia válida!")
        else:
            break

    while True:
        # A capacidade máxima de cada alojamento é defenido por uma variavel inteira, para que o utilizador não 
        # introduza um valor não inteiro utilizamos um try e exept. 
        try:
            maximum_capacity = int(input("Capacidade máxima do Alojamento << "))
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Caso este parametros sejam válidos cria um novo alojamento 
    new_alojamento = Alojamento(name, local, typology, maximum_capacity)
    alojamentos.add_alojamento(new_alojamento)
    print("*- Alojamento Criado! -*")


# Remove um alojamento
def remove_alojamento():
    # Começamos por mostrar todos os alojamentos guardados e pedimos o ID ao utilizador
    # do alojamento a remover 
    while True:
        print_alojamentos()
        try:
            id_al = int(input("ID do Alojamento que pretende remover [0 - Cancelar] << "))
            if id_al == 0:
                return id_al
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")
    # Caso este ID não exista então não volta a chamar a pedir o ID chamando a função
    if id_al not in alojamentos.dict_of_alojamentos().keys():
        print("\n""Número ID de Alojamento inexistente""\n")
        remove_alojamento()
    # Se o código existe então chama a função que irá remover o alojamento com o ID introduzido 
    else:
        # Esta função encontra-se na classe Alojamentos
        alojamentos.remove_alojamento(id_al)
        print("*- Alojamento Removido! -*")


# Atualiza um alojamento com os novos parametros
def update_alojamento():
    while True:
        print_alojamentos()
        id_al = input("ID do Alojamento que pretende alterar [0 - Cancelar] << ")
        try:
            id_al = int(id_al)
            if id_al == 0:
                return id_al
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    if id_al not in alojamentos.dict_of_alojamentos().keys():
        print("\n""Número ID de Alojamento inexistente""\n")
        remove_alojamento()
    # Se o Id introduzido estiver correto então pede os valores novos ao utilizador
    else:
        name = str(input("Introduza um nome novo << "))
        local = str(input("Introduza um local novo << "))
        typology = str(input("Introduza uma tipologia nova << "))

        while True:
            try:
                maximum_capacity = int(input("Capacidade máxima do Alojamento << "))
                break
            except ValueError:
                print("\nIntroduza um número válido!\n")

        new_alojamento = Alojamento(name, local, typology, maximum_capacity)
        alojamentos.update_al(id_al, new_alojamento)
        print("*- Alojamento Atualizado! -*")


# Mostra todos os alojamentos existentes e os seus parametros
def print_alojamentos():
    print("\n*----------------------------------------- Alojamentos -----------------------------------------*")
    for id_al, al in alojamentos.dict_of_alojamentos().items():
        name = al["name"]
        typology = al["typology"]
        local = al["local"]
        maximum_capacity = al["maximum_capacity"]
        likert = al["likert"]
        print(
            f"ID: {id_al}, Nome: {name}, Tipologia: {typology}, Local: {local}, Capacidade máxima: {maximum_capacity},"
            f" Likert: {likert}")
    print("*-----------------------------------------------------------------------------------------------*\n")

# Mostra todos os alojamentos com os seus parametros em expecifico 
def print_alojamentos_por_tipologia_e_likert() -> None: 

    tipologia = str(input("Tipologia do Alojamento que pretende listar << "))
    likert = int(input("Likert do Alojamento que pretende listar << "))

    flag = False 

    for id_al, al in alojamentos.dict_of_alojamentos().items():
        if al["typology"] == tipologia and al["likert"] <= likert:
            flag = True 
            print("\n*----------------------------------------- Alojamentos -----------------------------------------*")
            name = al["name"]
            typology = al["typology"]
            local = al["local"]
            maximum_capacity = al["maximum_capacity"]
            likert = al["likert"]
            print(
                f"ID: {id_al}, Nome: {name}, Tipologia: {typology}, Local: {local}, Capacidade máxima: {maximum_capacity},"
                f" Likert: {likert}")
            print("*-----------------------------------------------------------------------------------------------*\n")
    if not flag:
        print("*- Não existem alojamentos com estes parametros -*")
        
    return None


# RESERVAS

# Função para a reserva de alojamentos 
def reserve_alojamento():
    while True:
        print_alojamentos()
        try:
            id_al = int(input("ID do Alojamento que pretende fazer uma reserva [0 - Cancelar] << "))
            if id_al == 0:
                return id_al
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    if id_al not in alojamentos.dict_of_alojamentos().keys():
        print("\nNúmero ID de Alojamento inexistente\n")
        reserve_alojamento()

    # Obtemos a data de reserva do alojamento
    check_in_date = check_date()

    while True:
        number_days = input("Número de dias << ")
        try:
            number_days = int(number_days)
        except ValueError:
            print("\nIntroduza um número/dia válido!")
        if number_days in range(1, 32):
            break
    while True:
        try:
            number_occupants = int(input("Número de ocupantes << "))
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Obtemos o ID do atual utilizador
    client_id = clientes.get_user_id()

    # Verificamos se o alojamento escolhido está disponivel 
    success_booking = alojamentos.consult_availability(id_al, check_in_date, number_days, number_occupants)
    while not success_booking:
        check_in_date = check_date()
        success_booking = alojamentos.consult_availability(id_al, check_in_date, number_days, number_occupants)

    # Realização do booking onde obtemos a informação do booking, é atribuido o ID com a key do dicionario 
    # e atribuimos o booking ao cliente e alojamentos 
    booking_info = clientes.generate_booking_info(client_id, id_al, check_in_date, number_days, number_occupants)
    booking_id = list(booking_info.keys())[0]
    clientes.add_booking(client_id, id_al, booking_info)
    alojamentos.add_booking(client_id, id_al, booking_id, booking_info)
    print("*- Reserva Efetuada! -*")


# Verificar a disponibilidade de cada alojamento
def check_availability():
    while True:
        print_alojamentos()
        try:
            id_al = int(input("ID do Alojamento que pretende consultar [0 - Cancelar] << "))
            if id_al == 0:
                return id_al
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    if id_al not in alojamentos.dict_of_alojamentos().keys():
        print("\n""Número ID de Alojamento inexistente""\n")
        check_availability()

    check_in_date = check_date()

    while True:
        number_days = input("Número de dias << ")
        try:
            number_days = int(number_days)
        except ValueError:
            print("\nIntroduza um número/dia válido!")
        if number_days in range(1, 32):
            break
    while True:
        try:
            number_occupants = int(input("Número de ocupantes << "))
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    # Depois de receber toda a informação de reserva verificamos se o booking é possivel ou não
    success_booking = alojamentos.consult_availability(id_al, check_in_date, number_days, number_occupants)
    if not success_booking:
        print("*- O Alojamento não se encontra disponível para esta data -*")
    print("*- O Alojamento encontra-se disponível para esta data -*")


# Função para atribuir uma avaliação ao alojamento
def rate_alojamento():
    id_cl = clientes.get_user_id()
    # Com o ID do utilizador atual verificamos a história do seu booking
    booking_history = {}
    for id_al, bh in clientes.get_booking_history(id_cl).items():
        booking_history.update({id_al: bh})

    if not booking_history:
        print("\nAinda não fizeste uma reserva\n")

    # Mostre os alojamentos alugados 
    else:
        print("\n*--------------- ALOJAMENTOS ---------------*")
        for id_al, bh in booking_history.items():
            al_name = alojamentos.get_al_by_id(int(id_al))["name"]
            reservas = clientes.number_bookings_by_al(id_cl, id_al)
            number_like = clientes.number_bookings_with_likert(id_cl, id_al)
            print(f"ID: {id_al}, Nome: {al_name}, Quantidade de Reservas: {reservas}, "
                  f"Reservas Classificadas: {number_like}/{reservas}")
        print("*------------------------------------------*\n")

        # Recebe o ID do alojamento que contém a resevra que queira avaliar 
        while True:
            try:
                al_id = int(input("Introduza o ID do Alojamento que contém a Reserva a Classificar [0 - Cancelar] << "))
                if al_id == 0:
                    return al_id
                break
            except ValueError:
                print("\nIntroduza um número válido!")

        if str(al_id) not in booking_history.keys():
            print("\nNúmero ID de Alojamento inexistente\n")
            rate_alojamento()
        else:
            # Recebe a história de reserva do alojamento 
            reservas = clientes.get_booking_history(id_cl)[str(al_id)]
            check_out = None

            print("\n*------------- RESERVAS -------------*")
            for id_reserva, booking_info in reservas.items():
                check_out = booking_info["check_out"]
                if type(check_out) is not str:
                    check_out = check_out.strftime("%Y-%m-%d")
                clas = booking_info["likert"]
                print(f"ID: {id_reserva}, Data de Checkout: {check_out}, Classificação: {clas}")
            print("*------------------------------------*\n")

            while True:
                try:
                    reserve_id = int(input("Introduza o ID da Reserva, para classificá-la << "))
                    break
                except ValueError:
                    print("\nIntroduza um número válido!")

            if str(reserve_id) not in reservas.keys():
                print("\n""Número ID de Reserva inexistente""\n")
                rate_alojamento()

            # Se o alojamento conter reservas então mostre o menu de Likert
            else:
                print("""
                *---------- ESCALA DE LIKERT ----------* 
                1 - Muito Insatisfeito
                2 - Insatisfeito
                3 - Indiferente
                4 - Satisfeito
                5 - Muito Satisfeito
                *--------------------------------------* 
                """)

                while True:
                    likert = input("Classificação << ")
                    try:
                        likert = int(likert)
                    except ValueError:
                        print("\nIntroduza um número válido!")

                    # introdução do valor de likert
                    if likert not in range(1, 6):
                        print("Introduza um número de 1 a 5")
                    else:
                        break

                clientes.add_likert(id_cl, str(al_id), str(reserve_id), likert)
                alojamentos.add_likert(int(al_id), id_cl, str(reserve_id), check_out, likert)
                print("*- Classificação registada! -*")


# Generar o relatorio mensal 
def generate_relatorio_mensal():
    while True:
        print_alojamentos()
        try:
            id_al = int(input("ID do Alojamento que pretende gerar o relatório [0 - Cancelar] << "))
            if id_al == 0:
                return id_al
            break
        except ValueError:
            print("\nIntroduza um número válido!\n")

    if id_al not in alojamentos.dict_of_alojamentos().keys():
        print("\nNúmero ID de Alojamento inexistente\n")
        generate_relatorio_mensal()

    monthly_report = {}
    monthly_bookings = alojamentos.get_monthly_bookings(id_al, clientes)
    monthly_likert = alojamentos.get_monthly_likert(id_al)
    if len(monthly_bookings.keys()) == len(monthly_likert.keys()):
        for key in monthly_bookings.keys():
            aux_dict = {"Numero de Alugueres": monthly_bookings[key]}
            aux_dict.update(monthly_likert[key])
            monthly_report.update({
                key: aux_dict
            })
    # Cria o nome do ficheiro relatorio 
    filename = f"relatorio_mensal_{alojamentos.get_alojamentos()[id_al]['name']}.json"
    with open(f"relatorios/{filename}", "w") as report:
        report.write(json.dumps(monthly_report, indent=4, default=str))
    print("*- Relatório gerado! -*")


# Função para introdução de dia mês e ano
def check_date() -> datetime:
    while True:
        while True:
            year = input("\nIntroduza o ano da reserva << ")
            if year == "2022":
                break
            else:
                print("\nAno Inválido! Anos disponíveis para reserva [2022]")
        month = input("Introduza o mês da reserva << ")
        day = input("Introduza o dia da reserva << ")
        try:
            check_in_date = datetime(int(year), int(month), int(day))
            break
        except ValueError:
            print("\nIntroduza uma data válida!")
    return check_in_date


