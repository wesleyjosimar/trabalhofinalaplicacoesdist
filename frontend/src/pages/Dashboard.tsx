import React from 'react';
import { useQuery } from '@tanstack/react-query';
import { atletasService } from '../services/atletas.service';
import { antidopingService } from '../services/antidoping.service';
import './Dashboard.css';

const Dashboard: React.FC = () => {
  const { data: atletasData } = useQuery({
    queryKey: ['atletas', { page: 1, limit: 5 }],
    queryFn: () => atletasService.list({ page: 1, limit: 5 }),
  });

  const { data: testesData } = useQuery({
    queryKey: ['testes', { page: 1, limit: 5 }],
    queryFn: () => antidopingService.listTestes({ page: 1, limit: 5 }),
  });

  return (
    <div className="dashboard">
      <h1>Dashboard</h1>
      <div className="dashboard-grid">
        <div className="dashboard-card">
          <h2>Atletas Cadastrados</h2>
          <p className="dashboard-number">{atletasData?.total || 0}</p>
        </div>
        <div className="dashboard-card">
          <h2>Testes Realizados</h2>
          <p className="dashboard-number">{testesData?.total || 0}</p>
        </div>
      </div>
      <div className="dashboard-section">
        <h2>Últimos Atletas Cadastrados</h2>
        <div className="table-container">
          <table>
            <thead>
              <tr>
                <th>Nome</th>
                <th>Documento</th>
                <th>Data de Nascimento</th>
                <th>Federação</th>
              </tr>
            </thead>
            <tbody>
              {atletasData?.data.map((atleta) => (
                <tr key={atleta.id}>
                  <td>{atleta.nome}</td>
                  <td>{atleta.documento}</td>
                  <td>{new Date(atleta.dataNascimento).toLocaleDateString('pt-BR')}</td>
                  <td>{atleta.federacao?.sigla || '-'}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
      <div className="dashboard-section">
        <h2>Últimos Testes Antidoping</h2>
        <div className="table-container">
          <table>
            <thead>
              <tr>
                <th>Atleta</th>
                <th>Data de Coleta</th>
                <th>Local</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {testesData?.data.map((teste) => (
                <tr key={teste.id}>
                  <td>{teste.atleta?.nome || '-'}</td>
                  <td>{new Date(teste.dataColeta).toLocaleDateString('pt-BR')}</td>
                  <td>{teste.localColeta}</td>
                  <td>
                    {teste.amostras && teste.amostras.length > 0
                      ? teste.amostras[0].status
                      : 'Pendente'}
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;


