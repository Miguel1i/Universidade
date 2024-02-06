from alojamento import Alojamento
from datetime import datetime
from calendario import Calendario
from clientes import Clientes
import json


class Alojamentos:

    # Esta função tem como objetivo atribuir os valores aos objetos
    def __init__(self):
        self.alojamentos = {}
        self.alojamento_id_in_session = None

    # Abre o ficheiro e guarda os dados num dicionário
    def load_alojamentos(self) -> dict:
        with open("Alojamentos.json", "r") as al_file:
            raw_list_als = json.load(al_file)
        self.alojamentos = {int(id_al): al for id_al, al in raw_list_als.items()}
        return self.alojamentos

    # Escreve os dados num ficheiro .json
    def update_alojamentos(self) -> None:
        self.set_mean_likert()
        with open("Alojamentos.json", "w") as al:
            al.write(json.dumps(self.alojamentos, indent=4, default=str))
            return None

    # Define a média de likes para cada alojamento
    def set_mean_likert(self):
        for al_id, al in self.alojamentos.items():
            calendar = Calendario(al["calendario"])
            al["likert"] = calendar.get_mean_likert()

    # Carrega o dicionário e adiciona um novo alojamento
    def add_alojamento(self, alojamento: Alojamento) -> None:
        self.load_alojamentos()

        self.alojamentos.update({
            self.generate_id(): alojamento.to_dict()
        })
        self.update_alojamentos()
        return None

    # Carrega os alojamentos, remove o alojamento com o id determinado e guarda os alojamentos no ficheiro
    def remove_alojamento(self, id_al: int):
        self.load_alojamentos()
        self.alojamentos.pop(id_al)
        self.update_alojamentos()

    # Retorna uma lista com todos os nomes encontrados com o nome especificado
    def find_al_by_name(self, name: str):
        self.load_alojamentos()

        matched_als = []

        for id_al, al in self.alojamentos.items():

            if name.lower() in al["name"].lower():
                matched_als.append({id_al: al})

        if not matched_als:
            print("Nenhum alojamento encontrado.")
            return None

        return matched_als

    def update_al(self, id_al: int, new_al: Alojamento) -> None:
        self.load_alojamentos()
        self.alojamentos[id_al] = new_al.to_dict()
        self.update_alojamentos()
        return None

    # Retorna um código unico a cada alojamento
    def generate_id(self):

        if not self.alojamentos:
            return 1

        existing_ids = self.alojamentos.keys()
        return max(existing_ids) + 1

    # Verifica se existe um id especifico
    def check_id(self, id_al: int):

        self.load_alojamentos()

        if id_al in self.alojamentos.keys():
            return id_al
        else:
            print("Id inexistente!")

    # Retorna um dicionário dos alojamentos
    def dict_of_alojamentos(self) -> dict:
        self.load_alojamentos()
        return self.alojamentos

    # Retorna um id do alojamento
    def get_alojamento_id(self) -> int:
        return self.alojamento_id_in_session

    # O Alojamento recebe um id
    def set_alojamento_id(self, id_al: int) -> None:
        self.alojamento_id_in_session = id_al
        return None

    # Reservas

    # Retorna um didcionário com os alojamentos que contêm o id escolhido
    def get_al_by_id(self, id_al: int) -> dict:
        return self.get_alojamentos()[id_al]

    def get_alojamentos(self) -> dict:
        self.load_alojamentos()
        return self.alojamentos

    # adiciona um booking
    def add_booking(self, client_id: int, id_al: int, booking_id: str, booking_info: dict):
        self.load_alojamentos()
        cal_dict = self.alojamentos[id_al]["calendario"]
        calendar = Calendario(cal_dict)
        successful_booking = calendar.add_booking(client_id, booking_id, booking_info)
        if successful_booking:
            self.update_alojamentos()
        return successful_booking

    # Carrega o dcicionário, e verifica se o alojamento está disponivel, caso esteja retorna verdade caso contrário
    # retorna falso
    def consult_availability(self, id_al: int, check_in_date: datetime, number_days: int,
                             number_occupants: int) -> bool:
        self.load_alojamentos()
        cal_dict = self.alojamentos[id_al]["calendario"]
        calendar = Calendario(cal_dict)
        max_occupancy = self.alojamentos[id_al]["maximum_capacity"]
        successful_booking = calendar.check_availability(check_in_date, number_days, number_occupants, max_occupancy)
        if successful_booking:
            return True
        else:
            return False

    # Adiciona likert
    def add_likert(self, id_al: int, id_cl: int, booking_id: str, check_out_day: str, likert: int):
        cal_dict = self.alojamentos[id_al]["calendario"]
        calendar = Calendario(cal_dict)
        calendar.add_likert(id_cl, booking_id, check_out_day, likert)
        self.update_alojamentos()

    # Recebe a classificação mensal do alojamento 
    def get_monthly_likert(self, id_al: int):
        cal_dict = self.alojamentos[id_al]["calendario"]
        calendar = Calendario(cal_dict)
        monthly_likert = calendar.get_monthly_likert()
        for month_key, likert_stats in monthly_likert.items():
            likert_stats.pop("likert")
        return monthly_likert

    # Recebe as reservas 
    def get_monthly_bookings(self, id_al: int, clientes: Clientes):
        cal_dict = self.alojamentos[id_al]["calendario"]
        calendar = Calendario(cal_dict)
        return calendar.get_monthly_bookings(id_al, clientes)

    # Genera o ID da reserva
    def generate_reserve_id(self, id_al) -> int:

        if not self.get_al_by_id(id_al)["bookings"]:
            return 1

        existing_ids = self.get_al_by_id(id_al)["bookings"].keys()
        return int(max(existing_ids)) + 1


# Recebe o mês e ano da key
def get_month_and_year_from_key(month_key: str) -> tuple:
    if "of" in month_key:
        lst_key = [el.strip() for el in month_key.split("of")]
        return lst_key[0], lst_key[1]
    return None, None
