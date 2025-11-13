import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import Login from './pages/Login';
import Dashboard from './pages/Dashboard';
import Atletas from './pages/Atletas';
import AtletaDetail from './pages/AtletaDetail';
import TestesAntidoping from './pages/TestesAntidoping';
import TesteDetail from './pages/TesteDetail';
import { AuthProvider, useAuth } from './contexts/AuthContext';
import Layout from './components/Layout';

const queryClient = new QueryClient();

function ProtectedRoute({ children }: { children: React.ReactNode }) {
  const { user, loading } = useAuth();

  if (loading) {
    return <div>Carregando...</div>;
  }

  if (!user) {
    return <Navigate to="/login" />;
  }

  return <>{children}</>;
}

function AppRoutes() {
  return (
    <Routes>
      <Route path="/login" element={<Login />} />
      <Route
        path="/"
        element={
          <ProtectedRoute>
            <Layout>
              <Dashboard />
            </Layout>
          </ProtectedRoute>
        }
      />
      <Route
        path="/atletas"
        element={
          <ProtectedRoute>
            <Layout>
              <Atletas />
            </Layout>
          </ProtectedRoute>
        }
      />
      <Route
        path="/atletas/:id"
        element={
          <ProtectedRoute>
            <Layout>
              <AtletaDetail />
            </Layout>
          </ProtectedRoute>
        }
      />
      <Route
        path="/testes"
        element={
          <ProtectedRoute>
            <Layout>
              <TestesAntidoping />
            </Layout>
          </ProtectedRoute>
        }
      />
      <Route
        path="/testes/:id"
        element={
          <ProtectedRoute>
            <Layout>
              <TesteDetail />
            </Layout>
          </ProtectedRoute>
        }
      />
    </Routes>
  );
}

function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <AuthProvider>
        <Router>
          <AppRoutes />
        </Router>
      </AuthProvider>
    </QueryClientProvider>
  );
}

export default App;


