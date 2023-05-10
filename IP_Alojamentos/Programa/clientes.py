import json
from datetime import datetime, timedelta

from cliente import Cliente

class Clientes:

    def __init__(self):
        self._clientes = {}
        self.user_id_in_session = None

    # carrega o ficheiro dos clientes
    def load_clientes(self) -> dict:
        with open("Users.json", "r") as cl_file:
            raw_list_cls = json.load(cl_file)
        self._clientes = {int(id_cl): cl for id_cl, cl in raw_list_cls.items()}
        return self._clientes

    # carrega os clientes para o ficheiro
    def update_clientes(self) -> None:
        with open("Users.json", "w") as cl_file:
            cl_file.write(json.dumps(self._clientes, indent=4, default=str))
        return None

    # Adiciona um cliente
    def add_cliente(self, cliente: Cliente) -> None:
        self.load_clientes()
        self._clientes.update({
            self.generate_cliente_id(): cliente.to_dict()
        })
        self.update_clientes()
        return None

    # Remove um cliente
    def remove_cliente(self, id_cl: int) -> None:
        self.load_clientes()
        self._clientes.pop(id_cl)
        self.update_clientes()
        return None

    # Atualiza um cliente
    def update_cliente(self, id_cl: int, new_cliente: Cliente) -> None:
        self.load_clientes()
        self._clientes[id_cl] = new_cliente.to_dict()
        self.update_clientes()
        return None

    # Carrega a informação de booking 
    def generate_booking_info(self, id_cl: int, id_al: int, check_in_date: datetime, number_days: int,
                              number_occupants: int):
        bookings = self._clientes[id_cl]["booking_history"]
        booking_id = None
        if str(id_al) in bookings.keys():
            existing_ids = [int(k) for k in bookings[str(id_al)].keys()]
            booking_id = str((max(existing_ids) + 1))
        else:
            booking_id = "1"
        return {
            booking_id: {
                "check_in_date": check_in_date.date(),
                "number_days": number_days,
                "check_out": check_in_date.date() + timedelta(days=number_days - 1),
                "number_occupants": number_occupants,
                "likert": None
            }
        }

    # Adiciona um booking
    def add_booking(self, id_cl: int, id_al: int, booking_info: dict):
        if str(id_al) in self._clientes[id_cl]["booking_history"].keys():
            self._clientes[id_cl]["booking_history"][str(id_al)].update(booking_info)
        else:
            self._clientes[id_cl]["booking_history"].update({id_al: booking_info})
        self.update_clientes()

    # Recebe o number de bookings
    def number_bookings_by_al(self, id_cl: int, id_al: str) -> int:
        return len(self._clientes[id_cl]["booking_history"][id_al].keys())

    # Recebe o numero de bookings por likert
    def number_bookings_with_likert(self, id_cl: int, id_al: str):
        bookings_with_likert = 0
        for booking_id, booking_info in self._clientes[id_cl]["booking_history"][id_al].items():
            if booking_info["likert"]:
                bookings_with_likert += 1
        return bookings_with_likert

    # Adiciona um likert
    def add_likert(self, id_cl: int, id_al: str, booking_id: str, likert: int):
        self._clientes[id_cl]["booking_history"][id_al][booking_id]["likert"] = likert
        self.update_clientes()

    # Recebe um booking por ID 
    def get_booking_by_ids(self, id_al: int, id_cl: int, booking_id: int):
        return self._clientes[id_cl]["booking_history"][str(id_al)][str(booking_id)]

    # Recebe ID do utilizador
    def get_user_id(self) -> int:
        return self.user_id_in_session

    # Dá ao utilizador um ID
    def set_user_id(self, user_id: int):
        self.user_id_in_session = user_id

    # Recebe o cliente
    def get_clientes(self) -> dict:
        self.load_clientes()
        return self._clientes

    # recebe a história de booking
    def get_booking_history(self, id_cl: int) -> dict:
        return self._clientes[id_cl]["booking_history"]

    # Genera o ID do cliente basiado na quantidade de clientes
    def generate_cliente_id(self) -> int:
        if not self._clientes:
            return 1

        existing_ids = self._clientes.keys()
        return max(existing_ids) + 1
