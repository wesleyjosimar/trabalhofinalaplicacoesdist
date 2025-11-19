import { Controller, Get } from '@nestjs/common';

@Controller()
export class AppController {
  @Get()
  getHello() {
    return {
      message: 'CBF API - Sistema de Gestão de Atletas e Antidoping',
      version: '1.0.0',
      status: 'running',
      endpoints: {
        auth: '/auth/login',
        atletas: '/atletas',
        antidoping: '/antidoping/testes',
        relatorios: '/relatorios',
        integracao: '/integracao',
      },
    };
  }

  @Get('health')
  getHealth() {
    return {
      status: 'ok',
      timestamp: new Date().toISOString(),
    };
  }
}

