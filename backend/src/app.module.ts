import { Module } from '@nestjs/common';
import { ConfigModule } from '@nestjs/config';
import { TypeOrmModule } from '@nestjs/typeorm';
import { AuthModule } from './auth/auth.module';
import { AtletasModule } from './atletas/atletas.module';
import { AntidopingModule } from './antidoping/antidoping.module';
import { RelatoriosModule } from './relatorios/relatorios.module';
import { IntegracaoModule } from './integracao/integracao.module';
import { SharedModule } from './shared/shared.module';
import { AppController } from './app.controller';

@Module({
  controllers: [AppController],
  imports: [
    ConfigModule.forRoot({
      isGlobal: true,
    }),
    TypeOrmModule.forRoot({
      type: 'postgres',
      host: process.env.DB_HOST || 'localhost',
      port: parseInt(process.env.DB_PORT || '5432'),
      username: process.env.DB_USER || 'postgres',
      password: process.env.DB_PASSWORD || 'postgres',
      database: process.env.DB_NAME || 'cbf_db',
      entities: [__dirname + '/**/*.entity{.ts,.js}'],
      synchronize: process.env.NODE_ENV !== 'production', // Apenas em desenvolvimento
      logging: process.env.NODE_ENV === 'development',
    }),
    SharedModule,
    AuthModule,
    AtletasModule,
    AntidopingModule,
    RelatoriosModule,
    IntegracaoModule,
  ],
})
export class AppModule {}


