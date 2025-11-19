import React, { useState } from 'react';
import { useQuery, useMutation, useQueryClient } from '@tanstack/react-query';
import { useNavigate } from 'react-router-dom';
import { atletasService, CreateAtletaDto } from '../services/atletas.service';
import './Atletas.css';

const Atletas: React.FC = () => {
  const [page, setPage] = useState(1);
  const [search, setSearch] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [formData, setFormData] = useState<CreateAtletaDto>({
    nome: '',
    documento: '',
    dataNascimento: '',
    federacaoId: '',
  });

  const navigate = useNavigate();
  const queryClient = useQueryClient();

  const { data, isLoading } = useQuery({
    queryKey: ['atletas', { page, nome: search }],
    queryFn: () => atletasService.list({ page, limit: 10, nome: search }),
  });

  const createMutation = useMutation({
    mutationFn: (data: CreateAtletaDto) => atletasService.create(data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['atletas'] });
      setShowModal(false);
      setFormData({
        nome: '',
        documento: '',
        dataNascimento: '',
        federacaoId: '',
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
    <div className="atletas">
      <div className="atletas-header">
        <h1>Atletas</h1>
        <button onClick={() => setShowModal(true)} className="btn-primary">
          Novo Atleta
        </button>
      </div>

      <div className="search-bar">
        <input
          type="text"
          placeholder="Buscar por nome..."
          value={search}
          onChange={(e) => setSearch(e.target.value)}
        />
      </div>

      <div className="table-container">
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Documento</th>
              <th>Data de Nascimento</th>
              <th>Federação</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            {data?.data.map((atleta) => (
              <tr key={atleta.id}>
                <td>{atleta.nome}</td>
                <td>{atleta.documento}</td>
                <td>{new Date(atleta.dataNascimento).toLocaleDateString('pt-BR')}</td>
                <td>{atleta.federacao?.sigla || '-'}</td>
                <td>
                  <button
                    onClick={() => navigate(`/atletas/${atleta.id}`)}
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
            <h2>Novo Atleta</h2>
            <form onSubmit={handleSubmit}>
              <div className="form-group">
                <label>Nome</label>
                <input
                  type="text"
                  value={formData.nome}
                  onChange={(e) => setFormData({ ...formData, nome: e.target.value })}
                  required
                />
              </div>
              <div className="form-group">
                <label>Documento</label>
                <input
                  type="text"
                  value={formData.documento}
                  onChange={(e) => setFormData({ ...formData, documento: e.target.value })}
                  required
                />
              </div>
              <div className="form-group">
                <label>Data de Nascimento</label>
                <input
                  type="date"
                  value={formData.dataNascimento}
                  onChange={(e) =>
                    setFormData({ ...formData, dataNascimento: e.target.value })
                  }
                  required
                />
              </div>
              <div className="form-group">
                <label>ID da Federação</label>
                <input
                  type="text"
                  value={formData.federacaoId}
                  onChange={(e) =>
                    setFormData({ ...formData, federacaoId: e.target.value })
                  }
                  required
                  placeholder="UUID da federação"
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

export default Atletas;


