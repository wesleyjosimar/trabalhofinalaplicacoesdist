@extends('layouts.app')

@section('title', 'Novo Usuário - CBF Antidoping')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Cadastrar Novo Usuário</h2>
        
        <form method="POST" action="/usuarios">
            @csrf
            <div class="form-group">
                <label for="nome">Nome *</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha *</label>
                <input type="password" id="senha" name="senha" class="form-control" required minlength="6">
            </div>
            
            <div class="form-group">
                <label for="perfil">Perfil *</label>
                <select id="perfil" name="perfil" class="form-control" required>
                    <option value="operacional">Operacional</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="/usuarios" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

