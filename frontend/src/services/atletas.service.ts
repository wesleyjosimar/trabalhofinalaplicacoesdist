import api from './api';

export interface Atleta {
  id: string;
  nome: string;
  documento: string;
  dataNascimento: string;
  clubeAtualId?: string;
  clubeAtual?: {
    id: string;
    nome: string;
  };
  federacaoId: string;
  federacao?: {
    id: string;
    nome: string;
    sigla: string;
  };
  posicao?: string;
  createdAt: string;
  updatedAt: string;
}

export interface CreateAtletaDto {
  nome: string;
  documento: string;
  dataNascimento: string;
  federacaoId: string;
  clubeAtualId?: string;
  posicao?: string;
}

export interface ListAtletasParams {
  page?: number;
  limit?: number;
  nome?: string;
  documento?: string;
  federacaoId?: string;
  clubeId?: string;
}

export interface ListAtletasResponse {
  data: Atleta[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
}

export const atletasService = {
  async list(params?: ListAtletasParams): Promise<ListAtletasResponse> {
    const response = await api.get<ListAtletasResponse>('/atletas', { params });
    return response.data;
  },

  async getById(id: string): Promise<Atleta> {
    const response = await api.get<Atleta>(`/atletas/${id}`);
    return response.data;
  },

  async create(data: CreateAtletaDto): Promise<Atleta> {
    const response = await api.post<Atleta>('/atletas', data);
    return response.data;
  },

  async update(id: string, data: Partial<CreateAtletaDto>): Promise<Atleta> {
    const response = await api.patch<Atleta>(`/atletas/${id}`, data);
    return response.data;
  },

  async delete(id: string): Promise<void> {
    await api.delete(`/atletas/${id}`);
  },

  async getHistorico(id: string) {
    const response = await api.get(`/atletas/${id}/historico`);
    return response.data;
  },
};


