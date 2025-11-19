import React, { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useNavigate } from 'react-router-dom';
import { antidopingService, CreateTesteDto } from '../services/antidoping.service';
import { atletasService } from '../services/atletas.service';
import './TestesAntidoping.css';

const TestesAntidoping: React.FC = () => {
  const [page, setPage] = useState(1);
  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState<CreateTesteDto>({
    atletaId: '',
    dataColeta: '',
    localColeta: '',
    coletor: '',
  });

  const navigate = useNavigate();
  const queryClient = useQueryClient();

  const { data, isLoading } = useQuery({
    queryKey: ['testes', { page }],
    queryFn: () => antidopingService.listTestes({ page, limit: 10 }),
  });

  const { data: atletas } = useQuery({
    queryKey: ['atletas'],
    queryFn: () => atletasService.list({ limit: 100 }),
  });

  const createMutation = useMutation({
    mutationFn: (data: CreateTesteDto) => antidopingService.createTeste(data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['testes'] });
      setShowModal(false);
      setFormData({
        atletaId: '',
        dataColeta: '',
        localColeta: '',
        coletor: '',
      });
    },
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    createMutation.mutate(formData);
  };

  if (isLoading) {
    return <div>Carregando...</div>;
  }

  return (
    <div className="testes">
      <div className="testes-header">
        <h1>Testes Antidoping</h1>
        <button onClick={() => setShowModal(true)} className="btn-primary">
          Novo Teste
        </button>
      </div>

      <div className="table-container">
        <table>
          <thead>
            <tr>
              <th>Atleta</th>
              <th>Data de Coleta</th>
              <th>Local</th>
              <th>Coletor</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            {data?.data.map((teste) => (
              <tr key={teste.id}>
                <td>{teste.atleta?.nome || '-'}</td>
                <td>{new Date(teste.dataColeta).toLocaleDateString('pt-BR')}</td>
                <td>{teste.localColeta}</td>
                <td>{teste.coletor}</td>
                <td>
                  {teste.amostras && teste.amostras.length > 0
                    ? teste.amostras[0].status
                    : 'Pendente'}
                </td>
                <td>
                  <button
                    onClick={() => navigate(`/testes/${teste.id}`)}
                    className="btn-link"
                  >
                    Ver Detalhes
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      {data && data.totalPages > 1 && (
        <div className="pagination">
          <button
            onClick={() => setPage((p) => Math.max(1, p - 1))}
            disabled={page === 1}
          >
            Anterior
          </button>
          <span>
            Página {page} de {data.totalPages}
          </span>
          <button
            onClick={() => setPage((p) => Math.min(data.totalPages, p + 1))}
            disabled={page === data.totalPages}
          >
            Próxima
          </button>
        </div>
      )}

      {showModal && (
        <div className="modal-overlay" onClick={() => setShowModal(false)}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <h2>Novo Teste Antidoping</h2>
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label>Atleta</label>
                <select
                  value={formData.atletaId}
                  onChange={(e) => setFormData({ ...formData, atletaId: e.target.value })}
                  required
                >
                  <option value="">Selecione um atleta</option>
                  {atletas?.data.map((atleta) => (
                    <option key={atleta.id} value={atleta.id}>
                      {atleta.nome}
                    </option>
                  ))}
                </select>
              </div>
              <div className="form-group">
                <label>Data de Coleta</label>
                <input
                  type="datetime-local"
                  value={formData.dataColeta}
                  onChange={(e) =>
                    setFormData({ ...formData, dataColeta: e.target.value })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label>Local de Coleta</label>
                <input
                  type="text"
                  value={formData.localColeta}
                  onChange={(e) =>
                    setFormData({ ...formData, localColeta: e.target.value })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label>Coletor</label>
                <input
                  type="text"
                  value={formData.coletor}
                  onChange={(e) => setFormData({ ...formData, coletor: e.target.value })}
                  required
                />
              </div>
              <div className="modal-actions">
                <button type="button" onClick={() => setShowModal(false)}>
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
    </div>
  );
};

export default TestesAntidoping;


