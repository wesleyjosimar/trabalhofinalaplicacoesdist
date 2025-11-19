@extends('layouts.app')

@section('title', 'Login - CBF Antidoping')

@section('content')
<div style="max-width: 400px; margin: 5rem auto;">
    <div class="card">
        <h2 style="margin-bottom: 2rem; text-align: center; color: #006600;">CBF - Sistema Antidoping</h2>
        <h3 style="margin-bottom: 1.5rem; text-align: center;">Login</h3>
        
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">Entrar</button>
        </form>
    </div>
</div>
@endsection

