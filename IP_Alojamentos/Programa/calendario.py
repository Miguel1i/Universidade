from datetime import datetime, timedelta
from clientes import Clientes


class Calendario:
    def __init__(self, calendar_dict=None):
        self.calendario = calendar_dict
        self.first_day = datetime(2022, 1, 1)
        self.last_day = self.first_day.replace(year=self.first_day.year + 1)
        if calendar_dict is None:
            self.initialize_calendar()

    def get_calendar(self) -> dict:
        # Retorna o calendário
        return self.calendario

    def initialize_calendar(self):
        self.calendario = {}
        # Número de dias existentes
        calendar_delta = self.last_day - self.first_day
        # Lista de todos os dias
        all_days = [self.first_day + timedelta(days=n) for n in range(0, calendar_delta.days)]
        # Adiciona ao calendário os dias e a cada dia o número de reservas, a classificação e as reservas de clientes
        for day in all_days:
            self.calendario.update({date_to_str(day): {"reservas": str(0), "likert": {}, "bookings_by_client": {}}})

    def add_booking(self, client_id: int, booking_id: str, booking_info: dict) -> bool:
        """
        Utilidade: Adicionar uma Reserva
        :param client_id: ID do Cliente
        :param booking_id: ID da Reserva
        :param booking_info: Informação da Reserva
        :return:
        """
        # Deconstrução da informação da reserva
        check_in_date = booking_info[booking_id]["check_in_date"]
        number_days = booking_info[booking_id]["number_days"]
        number_occupants = booking_info[booking_id]["number_occupants"]

        # Dias a reservar
        booking_days = [date_to_str(check_in_date + timedelta(days=n)) for n in range(0, number_days)]
        # Por cada dia nos dias a reservar
        for day in booking_days:
            # O número de reservas daquele dia é alterado para o numero de ocupantes
            self.calendario[day]["reservas"] = str((int(self.calendario[day]["reservas"]) + number_occupants))

            # Se já existir uma reserva de um mesmo cliente naquele dia
            if str(client_id) in self.calendario[day]["bookings_by_client"].keys():
                # Adiciona o id da reserva à lista de reservas daquele cliente
                self.calendario[day]["bookings_by_client"][str(client_id)].append(booking_id)
            # Se não existir uma reserva de um mesmo cliente naquele dia
            else:
                # Atualiza o dicionário adicionando o id do outro cliente e o id da reserva
                self.calendario[day]["bookings_by_client"].update({
                    str(client_id): [booking_id]
                })
        return True

    def check_availability(self, check_in_date: datetime, number_days: int, number_occupants: int,
                           max_occupancy: int) -> bool:
        """
        Funcionalidade: Verificar a disponibilidade de um Alojamento local dado uma data, um número de dias e
        um número de ocupantes
        :param check_in_date: Data de check in
        :param number_days: Número de dias a reservar
        :param number_occupants: Número de ocupantes
        :param max_occupancy: Número máximo de ocupantes que o Alojamento permite
        :return: bool
        """
        # Dias a reservar
        booking_days = [date_to_str(check_in_date + timedelta(days=n)) for n in range(0, number_days)]

        # Dias ocupados
        occupied_days = []
        # Por cada dia nos dias a reservar
        for day in booking_days:
            # Verifica se o número de reservas existentes mais o número de ocupantes excede a capacidade máxima
            # do Alojamento naqueles dias e adiciona-os à lista occupied_days
            if int(self.calendario[day]["reservas"]) + number_occupants > max_occupancy:
                occupied_days.append(day)

        # Se a lista não estiver vazia -> print dos dias ocupados
        if occupied_days:
            print(f"\nNão é possível reservar nos seguintes dias: {', '.join(occupied_days)}.\nEscolha outra data.\n")
            return False
        return True

    def add_likert(self, id_cl: int, booking_id: str, check_out_day: str, likert: int) -> None:
        """
        Funcionalidade: Adicionar ao último dia reservado de uma reserva de um cliente uma classificação
        :param id_cl: ID do Cliente
        :param booking_id: ID da Reserva
        :param check_out_day: Último dia da reserva
        :param likert: Classificação
        :return: None
        """

        # Likert_id, será o ID do Cliente e o ID da Reserva a classificar do cliente
        likert_id = f"{str(id_cl)}-{booking_id}"

        # Atualiza a classificação do último da reserva a classificação dada pelo cliente
        self.calendario[check_out_day]["likert"].update({
            likert_id: likert
        })

    def get_mean_likert(self) -> float:
        """
        Funcionalidade: Obter a média de todos os dias classificados e associar ao rating do Alojamento
        :return: float
        """
        # Todas as classificações
        all_likerts = []
        # Por cada dia existente no calendario, adiciona-se a classificação desse dia à lista all_likerts
        for day, day_info in self.calendario.items():
            all_likerts.extend(list(day_info["likert"].values()))
        # Se a lista estiver vazia, a classificação daquele alojamento será 0.0
        if not all_likerts:
            return 0.0

        # Caso contrário a classificação do alojamento será a soma de todas as classificações a dividir
        # pelo número de classificações, arredondado a duas casas decimais
        return round((sum(all_likerts) / len(all_likerts)), 2)

    def get_monthly_bookings(self, id_al: int, clientes: Clientes) -> dict:
        """
        Funcionalidade: obter reservas mensais dado um id de um alojamento através das reservas dos clientes.
        :param id_al: ID do alojamento
        :param clientes:
        :return: dict
        """

        # Lista de todos os meses
        months = [m for m in range(1, 13)]
        monthly_stats = {}

        # Por cada mês na lista months
        for month in months:
            monthly_bookings = []
            last_day = None
            # Por cada informação de cada dia
            for day, day_info in self.calendario.items():
                # Se o mês daquele dia corresponder ao mês da lista months
                if str_to_date(day).month == month:
                    # Por cada booking de cada cliente
                    for client_id, bookings in day_info["bookings_by_client"].items():
                        # Por cada reserva nas reservas de cada cliente
                        for b_id in bookings:
                            unique_id_booking = f"{str(client_id)}-{str(b_id)}"
                            reserva = clientes.get_booking_by_ids(id_al, int(client_id), b_id)  # Reserva dos Clientes
                            checkout_day = str_to_date(reserva["check_out"])
                            checkout_month = checkout_day.month
                            # Se o mês de checkout corresponder ao mês da lista months
                            if checkout_month == month:
                                # A variável monthly_bookings irá conter todos os IDs das Reservas
                                monthly_bookings.append(unique_id_booking)
                    last_day = str_to_date(day)
            month_name = last_day.strftime("%B")
            month_key = f"{month_name} of {last_day.year}"

            # Atualiza o Dicionário monthly_stats tendo como key o nome do mês e o ano do último dia, e como values
            # O número de reservas, caso a variável não conter nada o value será 0
            monthly_stats.update({
                month_key: len(monthly_bookings) if monthly_bookings else 0
            })
        # retorna as reservas mensais
        return monthly_stats

    def get_monthly_likert(self) -> dict:
        """
        Funcionalidade: Obter a classificação de cada mês
        :return: dict
        """
        # Meses
        months = [m for m in range(1, 13)]

        monthly_stats = {}

        # Por cada mês da lista months
        for month in months:
            likerts = []
            last_day = None
            # Por cada informação de cada dia
            for day, day_info in self.calendario.items():
                # Se o mês daquele dia corresponder ao mês da lista months
                if str_to_date(day).month == month:
                    # Adiciona a lista que contém todas as classificações à lista likerts
                    likerts.extend([int(clas) for clas in list(day_info["likert"].values())])
                    last_day = str_to_date(day)

            month_name = last_day.strftime("%B")
            month_key = f"{month_name} of {last_day.year}"

            # Atualiza o dicionário monthly_stats tendo como key o nome do mês e o ano do último dia e como values
            # outro dicionário
            monthly_stats.update({
                month_key: {
                    "Classificacao Maxima": max(likerts) if likerts else None,
                    "Classificacao Minima": min(likerts) if likerts else None,
                    "Classificacao Moda": max(likerts, key=likerts.count) if likerts else None,
                    "likert": likerts
                }
            })
        # Retorna as estatisticas mensais
        return monthly_stats

    # Converte o Calendário em dicionário
    def to_dict(self):
        return self.calendario


# Converte um objeto da classe datetime em str
def date_to_str(date: datetime) -> str:
    return date.strftime("%Y-%m-%d")


# Converte uma data em formato de str para um objeto da classe datetime
def str_to_date(date: str) -> datetime:
    return datetime.strptime(date, "%Y-%m-%d")
