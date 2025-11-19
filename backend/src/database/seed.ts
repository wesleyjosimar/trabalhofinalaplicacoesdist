import { DataSource } from 'typeorm';
import * as bcrypt from 'bcrypt';
import { Usuario, PerfilUsuario } from '../shared/entities/usuario.entity';
import { Federacao } from '../shared/entities/federacao.entity';
import { Clube } from '../shared/entities/clube.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';

async function seedDatabase() {
  const dataSource = new DataSource({
    type: 'postgres',
    host: process.env.DB_HOST || 'localhost',
    port: parseInt(process.env.DB_PORT || '5432'),
    username: process.env.DB_USER || 'postgres',
    password: process.env.DB_PASSWORD || 'postgres',
    database: process.env.DB_NAME || 'cbf_db',
    entities: [__dirname + '/../**/*.entity{.ts,.js}'],
    synchronize: false,
    logging: true,
  });

  await dataSource.initialize();
  console.log('Conectado ao banco de dados');

  try {
    const usuarioRepository = dataSource.getRepository(Usuario);
    const federacaoRepository = dataSource.getRepository(Federacao);
    const clubeRepository = dataSource.getRepository(Clube);
    const laboratorioRepository = dataSource.getRepository(Laboratorio);

    // Criar Federação
    let federacao = await federacaoRepository.findOne({
      where: { sigla: 'CBF' },
    });
    if (!federacao) {
      federacao = federacaoRepository.create({
        nome: 'Confederação Brasileira de Futebol',
        sigla: 'CBF',
        nivel: 'nacional',
      });
      federacao = await federacaoRepository.save(federacao);
      console.log('Federação criada:', federacao.id);
    }

    // Criar Clube
    let clube = await clubeRepository.findOne({
      where: { nome: 'Clube de Teste' },
    });
    if (!clube) {
      clube = clubeRepository.create({
        nome: 'Clube de Teste',
        cidade: 'São Paulo',
        estado: 'SP',
        federacao: federacao,
      });
      clube = await clubeRepository.save(clube);
      console.log('Clube criado:', clube.id);
    }

    // Criar Laboratório
    let laboratorio = await laboratorioRepository.findOne({
      where: { codigo: 'LAB001' },
    });
    if (!laboratorio) {
      laboratorio = laboratorioRepository.create({
        nome: 'Laboratório de Teste',
        codigo: 'LAB001',
        pais: 'Brasil',
        ativo: true,
      });
      laboratorio = await laboratorioRepository.save(laboratorio);
      console.log('Laboratório criado:', laboratorio.id);
    }

    // Criar Usuário Admin
    let admin = await usuarioRepository.findOne({
      where: { email: 'admin@cbf.com.br' },
    });
    if (!admin) {
      const hashedPassword = await bcrypt.hash('admin123', 10);
      admin = usuarioRepository.create({
        email: 'admin@cbf.com.br',
        senha: hashedPassword,
        perfil: PerfilUsuario.CBF,
        nome: 'Administrador',
        ativo: true,
      });
      admin = await usuarioRepository.save(admin);
      console.log('Usuário admin criado:', admin.id);
    }

    // Criar Usuário Laboratório
    let usuarioLaboratorio = await usuarioRepository.findOne({
      where: { email: 'lab@teste.com.br' },
    });
    if (!usuarioLaboratorio) {
      const hashedPassword = await bcrypt.hash('lab123', 10);
      usuarioLaboratorio = usuarioRepository.create({
        email: 'lab@teste.com.br',
        senha: hashedPassword,
        perfil: PerfilUsuario.LABORATORIO,
        nome: 'Laboratório de Teste',
        organizacaoId: laboratorio.id,
        ativo: true,
      });
      usuarioLaboratorio = await usuarioRepository.save(usuarioLaboratorio);
      console.log('Usuário laboratório criado:', usuarioLaboratorio.id);
    }

    console.log('Seed concluído!');
    console.log('Usuários de teste:');
    console.log('  - admin@cbf.com.br / admin123 (CBF)');
    console.log('  - lab@teste.com.br / lab123 (LABORATORIO)');
  } catch (error) {
    console.error('Erro ao executar seed:', error);
    throw error;
  } finally {
    await dataSource.destroy();
  }
}

// Executar seed se chamado diretamente
if (require.main === module) {
  seedDatabase()
    .then(() => {
      console.log('Seed executado com sucesso!');
      process.exit(0);
    })
    .catch((error) => {
      console.error('Erro ao executar seed:', error);
      process.exit(1);
    });
}

export { seedDatabase };
