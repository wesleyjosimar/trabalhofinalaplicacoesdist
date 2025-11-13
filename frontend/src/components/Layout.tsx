import React from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../contexts/AuthContext';
import './Layout.css';

interface LayoutProps {
  children: React.ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
  const { user, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  return (
    <div className="layout">
      <header className="header">
        <div className="header-content">
          <h1 className="logo">CBF - Sistema de Gestão</h1>
          <nav className="nav">
            <Link to="/" className="nav-link">
              Dashboard
            </Link>
            <Link to="/atletas" className="nav-link">
              Atletas
            </Link>
            <Link to="/testes" className="nav-link">
              Testes Antidoping
            </Link>
          </nav>
          <div className="user-info">
            <span className="user-name">{user?.nome || user?.email}</span>
            <span className="user-perfil">{user?.perfil}</span>
            <button onClick={handleLogout} className="logout-btn">
              Sair
            </button>
          </div>
        </div>
      </header>
      <main className="main-content">{children}</main>
    </div>
  );
};

export default Layout;


