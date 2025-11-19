import React from 'react';
import { useParams } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { atletasService } from '../services/atletas.service';
import './AtletaDetail.css';

const AtletaDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();

  const { data: atleta, isLoading } = useQuery({
    queryKey: ['atleta', id],
    queryFn: () => atletasService.getById(id!),
    enabled: !!id,
  });

  const { data: historico } = useQuery({
    queryKey: ['atleta-historico', id],
    queryFn: () => atletasService.getHistorico(id!),
    enabled: !!id,
  });

  if (isLoading) {
    return <div>Carregando...</div>;
  }

  if (!atleta) {
    return <div>Atleta não encontrado</div>;
  }

  return (
    <div className="atleta-detail">
      <h1>Detalhes do Atleta</h1>
      <div className="detail-card">
        <h2>Informações Pessoais</h2>
        <div className="detail-grid">
          <div className="detail-item">
            <label>Nome</label>
            <p>{atleta.nome}</p>
          </div>
          <div className="detail-item">
            <label>Documento</label>
            <p>{atleta.documento}</p>
          </div>
          <div className="detail-item">
            <label>Data de Nascimento</label>
            <p>{new Date(atleta.dataNascimento).toLocaleDateString('pt-BR')}</p>
          </div>
          <div className="detail-item">
            <label>Federação</label>
            <p>{atleta.federacao?.nome || '-'}</p>
          </div>
          <div className="detail-item">
            <label>Clube Atual</label>
            <p>{atleta.clubeAtual?.nome || '-'}</p>
          </div>
          <div className="detail-item">
            <label>Posição</label>
            <p>{atleta.posicao || '-'}</p>
          </div>
        </div>
      </div>

      {historico && historico.length > 0 && (
        <div className="detail-card">
          <h2>Histórico de Clubes</h2>
          <div className="table-container">
            <table>
              <thead>
                <tr>
                  <th>Clube</th>
                  <th>Data Início</th>
                  <th>Data Fim</th>
                </tr>
              </thead>
              <tbody>
                {historico.map((item: any) => (
                  <tr key={item.id}>
                    <td>{item.clube?.nome || '-'}</td>
                    <td>{new Date(item.dataInicio).toLocaleDateString('pt-BR')}</td>
                    <td>{item.dataFim ? new Date(item.dataFim).toLocaleDateString('pt-BR') : '-'}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  );
};

export default AtletaDetail;


