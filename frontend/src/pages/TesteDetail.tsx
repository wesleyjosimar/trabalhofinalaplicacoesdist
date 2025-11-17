import React, { useState } from 'react';
import { useParams } from 'react-router-dom';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { antidopingService, CreateAmostraDto } from '../services/antidoping.service';
import './TesteDetail.css';

const TesteDetail: React.FC = () => {
  const { id } = useParams<{ id: string }>();
  const [showAmostraModal, setShowAmostraModal] = useState(false);
  const [showCustodiaModal, setShowCustodiaModal] = useState(false);
  const [amostraIdCustodia, setAmostraIdCustodia] = useState<string | null>(null);
  const [tipoAmostra, setTipoAmostra] = useState<'A' | 'B'>('A');

  const queryClient = useQueryClient();

  const { data: teste, isLoading } = useQuery({
    queryKey: ['teste', id],
    queryFn: () => antidopingService.getTesteById(id!),
    enabled: !!id,
  });

  const createAmostraMutation = useMutation({
    mutationFn: (data: CreateAmostraDto) =>
      antidopingService.createAmostra(id!, data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['teste', id] });
      setShowAmostraModal(false);
    },
  });

  const updateStatusMutation = useMutation({
    mutationFn: ({ amostraId, status }: { amostraId: string; status: string }) =>
      antidopingService.updateAmostraStatus(amostraId, status),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['teste', id] });
    },
  });

  const { data: cadeiaCustodia, isLoading: isLoadingCustodia } = useQuery({
    queryKey: ['cadeia-custodia', amostraIdCustodia],
    queryFn: () => antidopingService.getCadeiaCustodia(amostraIdCustodia!),
    enabled: !!amostraIdCustodia && showCustodiaModal,
  });

  const handleStatusChange = (amostraId: string, newStatus: string) => {
    if (window.confirm(`Deseja alterar o status da amostra para ${newStatus}?`)) {
      updateStatusMutation.mutate({ amostraId, status: newStatus });
    }
  };

  const handleCreateAmostra = (e: React.FormEvent) => {
    e.preventDefault();
    createAmostraMutation.mutate({ tipo: tipoAmostra });
  };

  if (isLoading) {
    return <div>Carregando...</div>;
  }

  if (!teste) {
    return <div>Teste não encontrado</div>;
  }

  return (
    <div className="teste-detail">
      <h1>Detalhes do Teste Antidoping</h1>
      <div className="detail-card">
        <h2>Informações do Teste</h2>
        <div className="detail-grid">
          <div className="detail-item">
            <label>Atleta</label>
            <p>{teste.atleta?.nome || '-'}</p>
          </div>
          <div className="detail-item">
            <label>Data de Coleta</label>
            <p>{new Date(teste.dataColeta).toLocaleDateString('pt-BR')}</p>
          </div>
          <div className="detail-item">
            <label>Local de Coleta</label>
            <p>{teste.localColeta}</p>
          </div>
          <div className="detail-item">
            <label>Coletor</label>
            <p>{teste.coletor}</p>
          </div>
          <div className="detail-item">
            <label>Competição</label>
            <p>{teste.competicao?.nome || '-'}</p>
          </div>
        </div>
      </div>

      <div className="detail-card">
        <div className="amostras-header">
          <h2>Amostras</h2>
          <button onClick={() => setShowAmostraModal(true)} className="btn-primary">
            Adicionar Amostra
          </button>
        </div>
        <div className="table-container">
          <table>
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Código</th>
                <th>Status</th>
                <th>Resultado</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              {teste.amostras && teste.amostras.length > 0 ? (
                teste.amostras.map((amostra) => (
                  <tr key={amostra.id}>
                    <td>{amostra.tipo}</td>
                    <td>{amostra.codigo}</td>
                    <td>{amostra.status}</td>
                    <td>{amostra.resultado?.resultado || '-'}</td>
                    <td>
                      <div style={{ display: 'flex', gap: '0.5rem', alignItems: 'center' }}>
                        {amostra.resultado && (
                          <button
                            onClick={() => {
                              setAmostraIdCustodia(amostra.id);
                              setShowCustodiaModal(true);
                            }}
                            className="btn-link"
                          >
                            Cadeia de Custódia
                          </button>
                        )}
                        {amostra.status === 'PENDENTE' && (
                          <select
                            value={amostra.status}
                            onChange={(e) => handleStatusChange(amostra.id, e.target.value)}
                            style={{ padding: '0.25rem', fontSize: '0.875rem' }}
                          >
                            <option value="PENDENTE">Pendente</option>
                            <option value="ANALISADA">Analisada</option>
                          </select>
                        )}
                        {amostra.status === 'ANALISADA' && !amostra.resultado && (
                          <select
                            value={amostra.status}
                            onChange={(e) => handleStatusChange(amostra.id, e.target.value)}
                            style={{ padding: '0.25rem', fontSize: '0.875rem' }}
                          >
                            <option value="ANALISADA">Analisada</option>
                            <option value="NEGATIVA">Negativa</option>
                            <option value="POSITIVA">Positiva</option>
                            <option value="INCONCLUSIVA">Inconclusiva</option>
                          </select>
                        )}
                      </div>
                    </td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan={5} style={{ textAlign: 'center' }}>
                    Nenhuma amostra registrada
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>

      {showAmostraModal && (
        <div className="modal-overlay" onClick={() => setShowAmostraModal(false)}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <h2>Adicionar Amostra</h2>
            <form onSubmit={handleCreateAmostra}>
              <div className="form-group">
                <label>Tipo de Amostra</label>
                <select
                  value={tipoAmostra}
                  onChange={(e) => setTipoAmostra(e.target.value as 'A' | 'B')}
                  required
                >
                  <option value="A">Amostra A</option>
                  <option value="B">Amostra B</option>
                </select>
              </div>
              <div className="modal-actions">
                <button type="button" onClick={() => setShowAmostraModal(false)}>
                  Cancelar
                </button>
                <button type="submit" className="btn-primary">
                  Salvar
                </button>
              </div>
            </form>
          </div>
        </div>
      )}

      {showCustodiaModal && (
        <div className="modal-overlay" onClick={() => {
          setShowCustodiaModal(false);
          setAmostraIdCustodia(null);
        }}>
          <div className="modal-content custodia-modal" onClick={(e) => e.stopPropagation()}>
            <h2>Cadeia de Custódia</h2>
            {isLoadingCustodia ? (
              <div>Carregando...</div>
            ) : cadeiaCustodia ? (
              <div className="custodia-content">
                <div className="custodia-section">
                  <h3>Informações da Amostra</h3>
                  <div className="detail-grid">
                    <div className="detail-item">
                      <label>Código</label>
                      <p>{cadeiaCustodia.amostra.codigo}</p>
                    </div>
                    <div className="detail-item">
                      <label>Tipo</label>
                      <p>Amostra {cadeiaCustodia.amostra.tipo}</p>
                    </div>
                    <div className="detail-item">
                      <label>Status</label>
                      <p>{cadeiaCustodia.amostra.status}</p>
                    </div>
                    <div className="detail-item">
                      <label>Data de Criação</label>
                      <p>{new Date(cadeiaCustodia.amostra.createdAt).toLocaleString('pt-BR')}</p>
                    </div>
                  </div>
                </div>

                <div className="custodia-section">
                  <h3>Informações do Teste</h3>
                  <div className="detail-grid">
                    <div className="detail-item">
                      <label>Atleta</label>
                      <p>{cadeiaCustodia.teste.atleta.nome}</p>
                    </div>
                    <div className="detail-item">
                      <label>Documento</label>
                      <p>{cadeiaCustodia.teste.atleta.documento}</p>
                    </div>
                    <div className="detail-item">
                      <label>Data de Coleta</label>
                      <p>{new Date(cadeiaCustodia.teste.dataColeta).toLocaleString('pt-BR')}</p>
                    </div>
                    <div className="detail-item">
                      <label>Local de Coleta</label>
                      <p>{cadeiaCustodia.teste.localColeta}</p>
                    </div>
                    <div className="detail-item">
                      <label>Coletor</label>
                      <p>{cadeiaCustodia.teste.coletor}</p>
                    </div>
                  </div>
                </div>

                {cadeiaCustodia.resultado && (
                  <div className="custodia-section">
                    <h3>Resultado da Análise</h3>
                    <div className="detail-grid">
                      <div className="detail-item">
                        <label>Resultado</label>
                        <p className={`resultado-${cadeiaCustodia.resultado.resultado.toLowerCase()}`}>
                          {cadeiaCustodia.resultado.resultado}
                        </p>
                      </div>
                      <div className="detail-item">
                        <label>Laboratório</label>
                        <p>{cadeiaCustodia.resultado.laboratorio.nome} ({cadeiaCustodia.resultado.laboratorio.codigo})</p>
                      </div>
                      <div className="detail-item">
                        <label>Data de Análise</label>
                        <p>{new Date(cadeiaCustodia.resultado.dataAnalise).toLocaleString('pt-BR')}</p>
                      </div>
                    </div>
                  </div>
                )}

                {cadeiaCustodia.eventos && cadeiaCustodia.eventos.length > 0 && (
                  <div className="custodia-section">
                    <h3>Histórico de Eventos</h3>
                    <div className="eventos-timeline">
                      {cadeiaCustodia.eventos.map((evento, index) => (
                        <div key={index} className="evento-item">
                          <div className="evento-header">
                            <span className="evento-tipo">{evento.tipo}</span>
                            <span className="evento-data">
                              {new Date(evento.data).toLocaleString('pt-BR')}
                            </span>
                          </div>
                          <div className="evento-usuario">Usuário: {evento.usuario}</div>
                          {evento.observacoes && (
                            <div className="evento-observacoes">{evento.observacoes}</div>
                          )}
                        </div>
                      ))}
                    </div>
                  </div>
                )}
              </div>
            ) : (
              <div>Erro ao carregar cadeia de custódia</div>
            )}
            <div className="modal-actions">
              <button type="button" onClick={() => {
                setShowCustodiaModal(false);
                setAmostraIdCustodia(null);
              }}>
                Fechar
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default TesteDetail;


