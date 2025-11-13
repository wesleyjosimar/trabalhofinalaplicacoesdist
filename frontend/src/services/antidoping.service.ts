import api from './api';

export interface TesteAntidoping {
  id: string;
  atletaId: string;
  atleta?: {
    id: string;
    nome: string;
    documento: string;
  };
  competicaoId?: string;
  competicao?: {
    id: string;
    nome: string;
  };
  dataColeta: string;
  localColeta: string;
  coletor: string;
  observacoes?: string;
  amostras?: Amostra[];
  createdAt: string;
  updatedAt: string;
}

export interface Amostra {
  id: string;
  testeId: string;
  tipo: 'A' | 'B';
  codigo: string;
  status: string;
  resultado?: Resultado;
}

export interface Resultado {
  id: string;
  amostraId: string;
  laboratorioId: string;
  laboratorio?: {
    id: string;
    nome: string;
    codigo: string;
  };
  resultado: 'NEGATIVO' | 'POSITIVO' | 'INCONCLUSIVO';
  dataAnalise: string;
  detalhes?: string;
  substanciaEncontrada?: string;
  concentracao?: string;
}

export interface CreateTesteDto {
  atletaId: string;
  competicaoId?: string;
  dataColeta: string;
  localColeta: string;
  coletor: string;
  observacoes?: string;
}

export interface CreateAmostraDto {
  tipo: 'A' | 'B';
  codigo?: string;
}

export interface CreateResultadoDto {
  laboratorioId: string;
  resultado: 'NEGATIVO' | 'POSITIVO' | 'INCONCLUSIVO';
  dataAnalise: string;
  detalhes?: string;
  substanciaEncontrada?: string;
  concentracao?: string;
}

export interface ListTestesParams {
  page?: number;
  limit?: number;
  atletaId?: string;
  competicaoId?: string;
  dataInicio?: string;
  dataFim?: string;
}

export interface ListTestesResponse {
  data: TesteAntidoping[];
  total: number;
  page: number;
  limit: number;
  totalPages: number;
}

export const antidopingService = {
  async listTestes(params?: ListTestesParams): Promise<ListTestesResponse> {
    const response = await api.get<ListTestesResponse>('/antidoping/testes', { params });
    return response.data;
  },

  async getTesteById(id: string): Promise<TesteAntidoping> {
    const response = await api.get<TesteAntidoping>(`/antidoping/testes/${id}`);
    return response.data;
  },

  async createTeste(data: CreateTesteDto): Promise<TesteAntidoping> {
    const response = await api.post<TesteAntidoping>('/antidoping/testes', data);
    return response.data;
  },

  async createAmostra(testeId: string, data: CreateAmostraDto): Promise<Amostra> {
    const response = await api.post<Amostra>(`/antidoping/testes/${testeId}/amostras`, data);
    return response.data;
  },

  async createResultado(amostraId: string, data: CreateResultadoDto): Promise<Resultado> {
    const response = await api.post<Resultado>(`/antidoping/amostras/${amostraId}/resultado`, data);
    return response.data;
  },

  async getCadeiaCustodia(amostraId: string) {
    const response = await api.get(`/antidoping/amostras/${amostraId}/custodia`);
    return response.data;
  },

  async solicitarReanalise(testeId: string) {
    const response = await api.post(`/antidoping/testes/${testeId}/reanalise`);
    return response.data;
  },

  async updateAmostraStatus(amostraId: string, status: string) {
    const response = await api.patch(`/antidoping/amostras/${amostraId}/status`, { status });
    return response.data;
  },
};


