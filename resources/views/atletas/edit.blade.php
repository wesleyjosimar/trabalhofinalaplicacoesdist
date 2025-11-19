@extends('layouts.app')

@section('title', 'Editar Atleta - CBF Antidoping')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Editar Atleta</h2>
        
        <form method="POST" action="/atletas/{{ $atleta->id }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" class="form-control" value="{{ $atleta->nome }}" required>
            </div>
            
            <div class="form-group">
                <label for="data_nascimento">Data de Nascimento *</label>
                <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" 
                       value="{{ $atleta->data_nascimento->format('Y-m-d') }}" required>
            </div>
            
            <div class="form-group">
                <label for="documento">Documento (CPF/RG) *</label>
                <input type="text" id="documento" name="documento" class="form-control" 
                       value="{{ $atleta->documento }}" required>
            </div>
            
            <div class="form-group">
                <label for="clube">Clube</label>
                <input type="text" id="clube" name="clube" class="form-control" value="{{ $atleta->clube }}">
            </div>
            
            <div class="form-group">
                <label for="federacao">Federação</label>
                <input type="text" id="federacao" name="federacao" class="form-control" value="{{ $atleta->federacao }}">
            </div>
            
            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="ativo" {{ $atleta->status === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ $atleta->status === 'inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/atletas" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

