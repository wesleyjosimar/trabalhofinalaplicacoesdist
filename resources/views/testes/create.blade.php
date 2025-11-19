@extends('layouts.app')

@section('title', 'Novo Teste - CBF Antidoping')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Registrar Novo Teste Antidoping</h2>
        
        <form method="POST" action="/testes">
            @csrf
            <div class="form-group">
                <label for="atleta_id">Atleta *</label>
                <select id="atleta_id" name="atleta_id" class="form-control" required>
                    <option value="">Selecione um atleta</option>
                    @foreach($atletas as $atleta)
                    <option value="{{ $atleta->id }}" 
                            {{ request('atleta_id') == $atleta->id ? 'selected' : '' }}>
                        {{ $atleta->nome }} - {{ $atleta->documento }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="data_coleta">Data de Coleta *</label>
                <input type="date" id="data_coleta" name="data_coleta" class="form-control" 
                       value="{{ date('Y-m-d') }}" required>
            </div>
            
            <div class="form-group">
                <label for="competicao">Competição</label>
                <input type="text" id="competicao" name="competicao" class="form-control">
            </div>
            
            <div class="form-group">
                <label for="laboratorio">Laboratório *</label>
                <input type="text" id="laboratorio" name="laboratorio" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="resultado">Resultado *</label>
                <select id="resultado" name="resultado" class="form-control" required>
                    <option value="pendente">Pendente</option>
                    <option value="negativo">Negativo</option>
                    <option value="positivo">Positivo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes" class="form-control" rows="4"></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/testes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

