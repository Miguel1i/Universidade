@extends('layouts.dashboard')
@section('title', 'Dashboard')


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <div class="search-container me-3">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <form action="/dashboard" method="GET">
                    {{csrf_field()}}
                    <input type="search" class="search-input" placeholder="Buscar medicamento..." name="search" value="{{$search}}">
                </form>
            </div>
            <button type="button" class="btn-adicionar" onclick="openAddPopup()">+ Adicionar</button>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th>Referência</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Indústria</th>
                    <th>Preço</th>
                    <th>Dosagem</th>
                    <th>Descricao</th>
                    <th>Forma</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($medicamentos as $medicamento)
                    <tr>
                        <td>{{ $medicamento->referencia }}</td>
                        <td>{{ $medicamento->nome }}</td>
                        <td>{{ $medicamento->quantidade }}</td>
                        <td>{{ $medicamento->industria }}</td>
                        <td>{{ $medicamento->preco }}</td>
                        <td>{{ $medicamento->dosagem }}</td>
                        <td>{{ $medicamento->descricao }}</td>
                        <td>{{ $medicamento->forma }}</td>
                        <td>{{ $medicamento->created_at->toFormattedDateString() }}</td>
                        <td>{{ $medicamento->updated_at->toFormattedDateString() }}</td>
                        <td>
                            <button type="button" class="btn btn-outline btn-icon" onclick="openEditPopup({{json_encode($medicamento)}})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                <span class="sr-only">Edit</span>
                            </button>
                            <form action="{{ route('medicamentos.destroy', $medicamento->referencia) }}" method="POST" onsubmit="return confirm('Tem a certeza que quer remover o medicamento ?');" style="display:inline;">
                                {{csrf_field()}}
                                @method('DELETE')
                                <button type="submit" class="btn btn-destructive btn-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                    <span class="sr-only">Delete</span>
                                </button>
                            </form>
                            <div class="modal fade" id="editMedicamentoModal" tabindex="-1" aria-labelledby="editMedicamentoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editMedicamentoModalLabel">Editar Medicamento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editMedicamentoForm" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <label for="editNome" class="form-label">Nome</label>
                                                    <input type="text" class="form-control" id="editNome" name="nome" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editQuantidade" class="form-label">Quantidade</label>
                                                    <input type="number" class="form-control" id="editQuantidade" name="quantidade" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editIndustria" class="form-label">Indústria</label>
                                                    <input type="text" class="form-control" id="editIndustria" name="industria" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editPreco" class="form-label">Preço</label>
                                                    <input type="number" step="any" class="form-control" id="editPreco" name="preco" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editDosagem" class="form-label">Dosagem</label>
                                                    <input type="text" class="form-control" id="editDosagem" name="dosagem" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editDescricao" class="form-label">Descrição</label>
                                                    <input type="text" class="form-control" id="editDescricao" name="descricao" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editForma" class="form-label">Forma</label>
                                                    <input type="text" class="form-control" id="editForma" name="forma" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Salvar Mudanças</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="addMedicamentoModal" tabindex="-1" aria-labelledby="addMedicamentoModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addMedicamentoModalLabel">Adicionar Medicamento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="addMedicamentoForm" method="POST" action="medicamentos/create">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="editReferencia" class="form-label">Referencia</label>
                                                    <input type="text" class="form-control" id="editReferencia" name="referencia" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="editNome" class="form-label">Nome</label>
                                                    <input type="text" class="form-control" id="editNome" name="nome" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editQuantidade" class="form-label">Quantidade</label>
                                                    <input type="number" class="form-control" id="editQuantidade" name="quantidade" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editIndustria" class="form-label">Indústria</label>
                                                    <input type="text" class="form-control" id="editIndustria" name="industria" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editPreco" class="form-label">Preço</label>
                                                    <input type="number" step="any" class="form-control" id="editPreco" name="preco" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editDosagem" class="form-label">Dosagem</label>
                                                    <input type="text" class="form-control" id="editDosagem" name="dosagem" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editDescricao" class="form-label">Descrição</label>
                                                    <input type="text" class="form-control" id="editDescricao" name="descricao" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="editForma" class="form-label">Forma</label>
                                                    <input type="text" class="form-control" id="editForma" name="forma" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Adicionar Medicamento</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-controls">
        @if(count($medicamentos) > 0)
            @if($page > 1)
                <a class="button" href="?page={{ $page - 1 }}&search={{ $search }}">Anterior</a>
            @endif

            @for($i = $start; $i <= $end; $i++)
                @if($i == $page)
                    <span class="button active">{{ $i }}</span>
                @else
                    <a class="button" href="?page={{ $i }}&search={{ $search }}">{{ $i }}</a>
                @endif
            @endfor

            @if($hasMore)
                <a class="button" href="?page={{ $page + 1 }}&search={{ $search }}">Avançar</a>
            @endif
        @endif
    </div>

    @error('referencia')
        <div class="alerta-error" id="alerta">{{ $message }}</div>
    @enderror

    @if (session('success'))
        <div class="alerta" id="alerta">{{ session('success') }}</div>
    @endif

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script>

    function openEditPopup(medicamento) {
        var form = document.getElementById('editMedicamentoForm');
        form.action = '/medicamentos/' + medicamento.referencia;
        document.getElementById('editDescricao').value = medicamento.descricao;
        document.getElementById('editPreco').value = medicamento.preco;
        document.getElementById('editForma').value = medicamento.forma;
        document.getElementById('editDosagem').value = medicamento.dosagem;
        document.getElementById('editNome').value = medicamento.nome;
        document.getElementById('editQuantidade').value = medicamento.quantidade;
        document.getElementById('editIndustria').value = medicamento.industria;
        var editModal = new bootstrap.Modal(document.getElementById('editMedicamentoModal'));
        editModal.show();
    }

    function openAddPopup() {
        var editModal = new bootstrap.Modal(document.getElementById('addMedicamentoModal'));
        editModal.show();
    }
    document.addEventListener("DOMContentLoaded", function () {
        const alerta = document.getElementById("alerta");
        if (alerta) {
            setTimeout(() => {
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-20px)';
                setTimeout(() => alerta.remove(), 300);
            }, 1500);
        }
    });
</script>

<style>

.alerta {
        flex: 1;
        flex-direction: row;
        position: fixed;
        top: 2rem;
        right: 2rem;
        transform: translateY(0);
        max-width: 500px;
        width: 95%;
        background-color: #e3f5f7;
        color: #149FA8;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: visibility 0.3s, opacity 0.3s, transform 0.3s;
        z-index: 1000;

    }
    .alerta-error {
        flex: 1;
        flex-direction: row;
        position: fixed;
        top: 2rem;
        right: 2rem;
        transform: translateY(0);
        max-width: 500px;
        width: 95%;
        background-color: rgb(244, 168, 168);
        color: red;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: visibility 0.3s, opacity 0.3s, transform 0.3s;
        z-index: 1000;

    }

    @media (max-width: 800px) {
        .alerta {
            top: 1rem;
            right: 1rem;
            padding: 0.8rem 1.5rem;
            font-size: 0.875rem;
        }
    }
    .pagination-controls {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
        gap: 10px;
    }

    .pagination-controls .button {
        color: black;
        text-decoration: none;
        pading: 0.75em 1em;
        border: 1px solid transparent;
        border-radius: 50px;
        opacity: 0.5;
    }

    .pagination-controls .button.active {
        opacity: 1;
    }

    .pagination-controls .button:hover {
        background-color: black;
        color: white;
    }

    .button {
        display: flex;
        z-index: 1;
        overflow: hidden;
        text-decoration: none;
        font-family: sans-serif;
        font-weight: 600;
        font-size: 1em;
        padding: 0.75em 1em;
        margin: 0;
        position: relative;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .me-3 {
        margin-right: 1rem;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #ffffff;
    }

    .container {
        max-width: 2000px;
        margin: 0 auto;
        padding: 24px;
    }

    .search-container {
        position: relative;
        max-width: 300px;
        margin-bottom: -20px;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-100%);
        width: 16px;
        height: 16px;
        color: #6b7280;
    }

    .search-input {
        width: 100%;
        padding: 8px 8px 8px 32px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 14px;
    }


    table {
        width: 100%;
        border-collapse: collapse;
        border: #6b7280;
        border-radius: 10%;
        border-left: 1px solid #e5e7eb;
        border-right: 1px solid #e5e7eb;
        border-top: 1px solid #e5e7eb;

    }

    th,
    td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;

    }


    th {
        background-color: #ffffff;
        font-weight: 600;
        color: #374151;
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
    }
    tr:hover {
        background-color: #f2f2f2;
    }


    th:first-child {
        border-top-left-radius: 8px;
    }
    th:last-child {
        border-top-right-radius: 8px;
    }


    td {
        padding: 18px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }



    .actions {
        text-align: right;
    }

    .btn {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid #d1d5db;
    }

    .btn-destructive {
        background-color: #ef4444;
        color: white;
    }
    .btn-adicionar {
        margin-bottom: -5px;
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        background-color: #149FA8;
        color: white;

    }

    .btn-icon {
        padding: 5px;
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    @media (max-width: 640px) {
        .container {
            padding: 16px;
        }

        th,
        td {
            padding: 8px;
        }
    }
</style>


