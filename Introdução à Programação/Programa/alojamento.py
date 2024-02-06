from calendario import Calendario


class Alojamento:

    # Esta função tem como objetivo atribuir os valores aos objetos
    def __init__(self, name: str, local: str, typology: str, maximum_capacity: int):
        self.name = name
        self.local = local
        self.typology = typology
        self.maximum_capacity = maximum_capacity
        self.likert = 0
        self.calendar = Calendario()

    # Retorna os valores do objeto Calendar
    def get_calendar(self):
        return self.calendar

    # Converte para dicionário
    def to_dict(self):
        return {
            "name": self.name,
            "local": self.local,
            "typology": self.typology,
            "maximum_capacity": self.maximum_capacity,
            "likert": self.likert,
            "calendario": self.calendar.to_dict()
        }
