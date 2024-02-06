from handle_clientes import clientes
import handle_clientes
import handle_alojamentos


def user_menu() -> None:
    print("""
       *-------------- USER -------------*
       1 - Login
       2 - Registar
       3 - Entrar como cibernauta
       4 - Sair
       *---------------------------------*
       """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        user_menu()
    match ans:
        case 1:
            handle_clientes.login()
            if clientes.get_clientes()[clientes.get_user_id()]["username"] == "admin":
                menu_admin()
            else:
                menu_cliente()
        case 2:
            handle_clientes.regist_cliente()
            user_menu()
        case 3:
            menu_cibernauta()
        case 4:
            print("Adeus!")
        case _:
            print("Introduza uma opção válida!")
            user_menu()
    return None


def menu_cibernauta() -> None:
    print("""
    *-------------- MENU -------------*
    1 - Listar alojamentos locais
    2 - Consultar um alojamento local
    3 - Sair
    *---------------------------------*
    """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida! 3")
        menu_cibernauta()
    match ans:
        case 1:
            handle_alojamentos.print_alojamentos()
            menu_cibernauta()
        case 2:
            handle_alojamentos.check_availability()
            menu_cibernauta()
        case 3:
            user_menu()
        case _:
            print("Introduza uma opção válida!")
            menu_cibernauta()
    return None


def menu_admin() -> None:
    print("""
    *------------------- MENU ------------------*
    1 - Gerir alojamentos locais
    2 - Gerir clientes
    3 - Listar alojamentos locais
    4 - Consultar um alojamento local
    5 - Alugar um alojamento local
    6 - Classificar a experiência num alojamento local
    7 - Gerar relatórios
    8 - Sair
    *-------------------------------------------*
    """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        menu_admin()
    match ans:
        case 1:
            manage_alojamentos()
        case 2:
            manage_clientes()
        case 3:
            handle_alojamentos.print_alojamentos()
            menu_admin()
        case 4:
            handle_alojamentos.check_availability()
            menu_admin()
        case 5:
            handle_alojamentos.reserve_alojamento()
            menu_admin()
        case 6:
            pass
        case 7:
            handle_alojamentos.generate_relatorio_mensal()
            menu_admin()
        case 8:
            user_menu()
        case _:
            print("Introduza uma opção válida!")
            menu_admin()
    return None


def menu_cliente() -> None:
    print("""
    *-------------- MENU -------------*
    1 - Listar alojamentos locais
    2 - Consultar um alojamento local
    3 - Alugar um alojamento local
    4 - Classificar a experiência num alojamento local
    5 - Sair
    *---------------------------------*
    """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        menu_cliente()
    match ans:
        case 1:
            listar_alojamentos() 
            menu_cliente()
        case 2:
            handle_alojamentos.check_availability()
            menu_cliente()
        case 3:
            handle_alojamentos.reserve_alojamento()
            menu_cliente()
        case 4:
            handle_alojamentos.rate_alojamento()
            menu_cliente()
        case 5:
            user_menu()
        case _:
            print("Introduza uma opção válida!")
            menu_cliente()
    return None


# SUBMENUS

def manage_alojamentos():
    print("""
        *------------------- SUBMENU ------------------*
        1 - Adicionar um Alojamento
        2 - Remover um Alojamento
        3 - Alterar um Alojamento
        4 - Sair
        *----------------------------------------------*
        """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        manage_alojamentos()

    match ans:
        case 1:
            handle_alojamentos.add_alojamento()
            manage_alojamentos()
        case 2:
            handle_alojamentos.remove_alojamento()
            if id == 0:
                manage_alojamentos()
            manage_alojamentos()
        case 3:
            handle_alojamentos.update_alojamento()
            manage_alojamentos()
        case 4:
            menu_admin()
        case _:
            print("Introduza uma opção válida!")
            manage_alojamentos()


def manage_clientes():
    print("""
        *------------------- SUBMENU ------------------*
        1 - Consultar um Cliente
        2 - Adicionar um Cliente
        3 - Remover um Cliente
        4 - Alterar um Cliente
        5 - Sair
        *----------------------------------------------*
        """)
    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        manage_alojamentos()
    match ans:
        case 1:
            handle_clientes.consult_cliente_by_id()
            manage_clientes()
        case 2:
            handle_clientes.regist_cliente()
            manage_clientes()
        case 3:
            handle_clientes.remove_cliente()
            manage_clientes()
        case 4:
            handle_clientes.change_cliente()
            manage_clientes()
        case 5:
            menu_admin()
        case _:
            print("Introduza uma opção válida!")
            manage_alojamentos()

def listar_alojamentos() -> None:
    print("""
        *-------------- MENU -------------*
        1 - Listar alojamentos locais
        2 - Listar por parametros tipologia e likert
        3 - Sair
        *---------------------------------*
        """)

    ans = 0
    try:
        ans = int(input("Opção << "))
    except ValueError:
        print("Introduza uma opção válida!")
        menu_cliente()
    match ans:
        case 1:
            handle_alojamentos.print_alojamentos()
            listar_alojamentos()
        case 2:
            handle_alojamentos.print_alojamentos_por_tipologia_e_likert()
            listar_alojamentos()
        case 3:
            menu_cliente() 
        case _:
            print("Introduza uma opção válida!")
            listar_alojamentos()
    return None

