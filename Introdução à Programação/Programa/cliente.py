class Cliente:

    def __init__(self, name: str, username: str, password: str):
        self.name = name
        self.username = username
        self.password = password
        self.booking_history = {}

# Converte o cliente em dicionario
    def to_dict(self) -> dict:
        return {
            "name": self.name,
            "username": self.username,
            "password": self.password,
            "booking_history": self.booking_history
        }
