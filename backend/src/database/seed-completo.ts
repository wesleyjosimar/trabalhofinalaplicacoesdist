import { DataSource } from 'typeorm';
import * as bcrypt from 'bcrypt';
import { Usuario, PerfilUsuario } from '../shared/entities/usuario.entity';
import { Federacao } from '../shared/entities/federacao.entity';
import { Clube } from '../shared/entities/clube.entity';
import { Laboratorio } from '../shared/entities/laboratorio.entity';
import { Atleta } from '../shared/entities/atleta.entity';
import { Competicao } from '../shared/entities/competicao.entity';
import { TesteAntidoping } from '../shared/entities/teste-antidoping.entity';
import { Amostra, TipoAmostra, StatusAmostra } from '../shared/entities/amostra.entity';
import { Resultado, TipoResultado } from '../shared/entities/resultado.entity';
import { HistoricoClube } from '../shared/entities/historico-clube.entity';

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
    logging: false,
  });

  await dataSource.initialize();
  console.log('✅ Conectado ao banco de dados');

  try {
    const usuarioRepository = dataSource.getRepository(Usuario);
    const federacaoRepository = dataSource.getRepository(Federacao);
    const clubeRepository = dataSource.getRepository(Clube);
    const laboratorioRepository = dataSource.getRepository(Laboratorio);
    const atletaRepository = dataSource.getRepository(Atleta);
    const competicaoRepository = dataSource.getRepository(Competicao);
    const testeRepository = dataSource.getRepository(TesteAntidoping);
    const amostraRepository = dataSource.getRepository(Amostra);
    const resultadoRepository = dataSource.getRepository(Resultado);
    const historicoRepository = dataSource.getRepository(HistoricoClube);

    console.log('\n📦 Iniciando seed do banco de dados...\n');

    // 1. Criar Federações
    console.log('1. Criando federações...');
    let cbf = await federacaoRepository.findOne({ where: { sigla: 'CBF' } });
    if (!cbf) {
      cbf = federacaoRepository.create({
        nome: 'Confederação Brasileira de Futebol',
        sigla: 'CBF',
        nivel: 'nacional',
      });
      cbf = await federacaoRepository.save(cbf);
      console.log('   ✅ CBF criada');
    } else {
      console.log('   ℹ️  CBF já existe');
    }

    let fpf = await federacaoRepository.findOne({ where: { sigla: 'FPF' } });
    if (!fpf) {
      fpf = federacaoRepository.create({
        nome: 'Federação Paulista de Futebol',
        sigla: 'FPF',
        nivel: 'estadual',
      });
      fpf = await federacaoRepository.save(fpf);
      console.log('   ✅ FPF criada');
    } else {
      console.log('   ℹ️  FPF já existe');
    }

    // 2. Criar Clubes
    console.log('\n2. Criando clubes...');
    const clubes = [
      { nome: 'Palmeiras', cidade: 'São Paulo', estado: 'SP', federacao: fpf },
      { nome: 'Corinthians', cidade: 'São Paulo', estado: 'SP', federacao: fpf },
      { nome: 'Flamengo', cidade: 'Rio de Janeiro', estado: 'RJ', federacao: cbf },
      { nome: 'São Paulo', cidade: 'São Paulo', estado: 'SP', federacao: fpf },
      { nome: 'Santos', cidade: 'Santos', estado: 'SP', federacao: fpf },
    ];

    const clubesCriados = [];
    for (const clubeData of clubes) {
      let clube = await clubeRepository.findOne({ where: { nome: clubeData.nome } });
      if (!clube) {
        clube = clubeRepository.create(clubeData);
        clube = await clubeRepository.save(clube);
        console.log(`   ✅ ${clube.nome} criado`);
      } else {
        console.log(`   ℹ️  ${clube.nome} já existe`);
      }
      clubesCriados.push(clube);
    }

    // 3. Criar Laboratórios
    console.log('\n3. Criando laboratórios...');
    const laboratorios = [
      { nome: 'Laboratório Brasileiro de Controle de Dopagem', codigo: 'LBCD001', pais: 'Brasil' },
      { nome: 'Laboratório de Análises Antidoping', codigo: 'LAA002', pais: 'Brasil' },
    ];

    const laboratoriosCriados = [];
    for (const labData of laboratorios) {
      let lab = await laboratorioRepository.findOne({ where: { codigo: labData.codigo } });
      if (!lab) {
        lab = laboratorioRepository.create({
          ...labData,
          ativo: true,
        });
        lab = await laboratorioRepository.save(lab);
        console.log(`   ✅ ${lab.nome} criado`);
      } else {
        console.log(`   ℹ️  ${lab.nome} já existe`);
      }
      laboratoriosCriados.push(lab);
    }

    // 4. Criar Usuários
    console.log('\n4. Criando usuários...');
    const usuarios = [
      {
        email: 'admin@cbf.com.br',
        senha: 'admin123',
        perfil: PerfilUsuario.CBF,
        nome: 'Administrador CBF',
        organizacaoId: null,
      },
      {
        email: 'lab@teste.com.br',
        senha: 'lab123',
        perfil: PerfilUsuario.LABORATORIO,
        nome: 'Laboratório de Teste',
        organizacaoId: laboratoriosCriados[0].id,
      },
      {
        email: 'federacao@fpf.com.br',
        senha: 'fpf123',
        perfil: PerfilUsuario.FEDERACAO,
        nome: 'Federação Paulista',
        organizacaoId: fpf.id,
      },
    ];

    for (const usuarioData of usuarios) {
      let usuario = await usuarioRepository.findOne({ where: { email: usuarioData.email } });
      if (!usuario) {
        const hashedPassword = await bcrypt.hash(usuarioData.senha, 10);
        usuario = usuarioRepository.create({
          ...usuarioData,
          senha: hashedPassword,
          ativo: true,
        });
        usuario = await usuarioRepository.save(usuario);
        console.log(`   ✅ Usuário ${usuario.email} criado`);
      } else {
        console.log(`   ℹ️  Usuário ${usuario.email} já existe`);
      }
    }

    // 5. Criar Competições
    console.log('\n5. Criando competições...');
    const competicoes = [
      {
        nome: 'Campeonato Brasileiro Série A 2024',
        dataInicio: new Date('2024-04-01'),
        dataFim: new Date('2024-12-15'),
        tipo: 'campeonato',
        federacao: cbf,
      },
      {
        nome: 'Campeonato Paulista 2024',
        dataInicio: new Date('2024-01-15'),
        dataFim: new Date('2024-04-15'),
        tipo: 'campeonato',
        federacao: fpf,
      },
    ];

    const competicoesCriadas = [];
    for (const compData of competicoes) {
      let comp = await competicaoRepository.findOne({ where: { nome: compData.nome } });
      if (!comp) {
        comp = competicaoRepository.create(compData);
        comp = await competicaoRepository.save(comp);
        console.log(`   ✅ ${comp.nome} criada`);
      } else {
        console.log(`   ℹ️  ${comp.nome} já existe`);
      }
      competicoesCriadas.push(comp);
    }

    // 6. Criar Atletas
    console.log('\n6. Criando atletas...');
    const atletasData = [
      {
        nome: 'João Silva',
        documento: '12345678900',
        dataNascimento: new Date('1995-05-15'),
        clubeAtual: clubesCriados[0],
        federacao: fpf,
        posicao: 'Atacante',
      },
      {
        nome: 'Maria Santos',
        documento: '98765432100',
        dataNascimento: new Date('1998-08-20'),
        clubeAtual: clubesCriados[1],
        federacao: fpf,
        posicao: 'Meio-campo',
      },
      {
        nome: 'Pedro Oliveira',
        documento: '11122233344',
        dataNascimento: new Date('1996-03-10'),
        clubeAtual: clubesCriados[2],
        federacao: cbf,
        posicao: 'Goleiro',
      },
      {
        nome: 'Ana Costa',
        documento: '55566677788',
        dataNascimento: new Date('1997-11-25'),
        clubeAtual: clubesCriados[3],
        federacao: fpf,
        posicao: 'Defensor',
      },
      {
        nome: 'Carlos Ferreira',
        documento: '99988877766',
        dataNascimento: new Date('1994-07-30'),
        clubeAtual: clubesCriados[4],
        federacao: fpf,
        posicao: 'Atacante',
      },
    ];

    const atletasCriados = [];
    for (const atletaData of atletasData) {
      let atleta = await atletaRepository.findOne({ where: { documento: atletaData.documento } });
      if (!atleta) {
        atleta = atletaRepository.create(atletaData);
        atleta = await atletaRepository.save(atleta);

        // Criar histórico do clube
        const historico = historicoRepository.create({
          atleta,
          clube: atletaData.clubeAtual,
          dataInicio: new Date(),
        });
        await historicoRepository.save(historico);

        console.log(`   ✅ Atleta ${atleta.nome} criado`);
      } else {
        console.log(`   ℹ️  Atleta ${atleta.nome} já existe`);
      }
      atletasCriados.push(atleta);
    }

    // 7. Criar Testes Antidoping
    console.log('\n7. Criando testes antidoping...');
    const testesData = [
      {
        atleta: atletasCriados[0],
        competicao: competicoesCriadas[0],
        dataColeta: new Date('2024-05-15T10:00:00'),
        localColeta: 'Estádio Allianz Parque',
        coletor: 'Dr. Roberto Silva',
        observacoes: 'Coleta realizada após partida',
      },
      {
        atleta: atletasCriados[1],
        competicao: competicoesCriadas[0],
        dataColeta: new Date('2024-05-20T14:30:00'),
        localColeta: 'Arena Corinthians',
        coletor: 'Dr. Maria Santos',
        observacoes: 'Coleta de rotina',
      },
      {
        atleta: atletasCriados[2],
        competicao: competicoesCriadas[1],
        dataColeta: new Date('2024-02-10T09:00:00'),
        localColeta: 'Maracanã',
        coletor: 'Dr. João Oliveira',
        observacoes: 'Teste surpresa',
      },
      {
        atleta: atletasCriados[3],
        competicao: competicoesCriadas[1],
        dataColeta: new Date('2024-03-05T16:00:00'),
        localColeta: 'Morumbi',
        coletor: 'Dr. Ana Costa',
        observacoes: 'Coleta após treino',
      },
    ];

    const testesCriados = [];
    for (const testeData of testesData) {
      const teste = testeRepository.create(testeData);
      const testeSalvo = await testeRepository.save(teste);
      testesCriados.push(testeSalvo);
      console.log(`   ✅ Teste para ${testeData.atleta.nome} criado`);
    }

    // 8. Criar Amostras
    console.log('\n8. Criando amostras...');
    for (let i = 0; i < testesCriados.length; i++) {
      const teste = testesCriados[i];

      // Amostra A
      const amostraA = amostraRepository.create({
        teste,
        tipo: TipoAmostra.A,
        codigo: `AMA-${Date.now()}-${i}-A`,
        status: i < 2 ? StatusAmostra.ANALISADA : StatusAmostra.PENDENTE,
      });
      const amostraASalva = await amostraRepository.save(amostraA);
      console.log(`   ✅ Amostra A criada para teste ${i + 1}`);

      // Amostra B
      const amostraB = amostraRepository.create({
        teste,
        tipo: TipoAmostra.B,
        codigo: `AMB-${Date.now()}-${i}-B`,
        status: StatusAmostra.PENDENTE,
      });
      await amostraRepository.save(amostraB);
      console.log(`   ✅ Amostra B criada para teste ${i + 1}`);

      // Criar resultado para os primeiros 2 testes
      if (i < 2) {
        const resultado = resultadoRepository.create({
          amostra: amostraASalva,
          laboratorio: laboratoriosCriados[0],
          resultado: i === 0 ? TipoResultado.NEGATIVO : TipoResultado.POSITIVO,
          dataAnalise: new Date(),
          detalhes: i === 0 ? 'Teste negativo, sem substâncias proibidas' : 'Teste positivo para substância proibida',
          substanciaEncontrada: i === 1 ? 'Anabolizante' : null,
          concentracao: i === 1 ? '10 ng/mL' : null,
        });
        await resultadoRepository.save(resultado);

        // Atualizar status da amostra
        amostraASalva.status = i === 0 ? StatusAmostra.NEGATIVA : StatusAmostra.POSITIVA;
        await amostraRepository.save(amostraASalva);

        console.log(`   ✅ Resultado ${i === 0 ? 'NEGATIVO' : 'POSITIVO'} criado para teste ${i + 1}`);
      }
    }

    console.log('\n✅ Seed concluído com sucesso!');
    console.log('\n📊 Resumo:');
    console.log(`   - Federações: ${await federacaoRepository.count()}`);
    console.log(`   - Clubes: ${await clubeRepository.count()}`);
    console.log(`   - Laboratórios: ${await laboratorioRepository.count()}`);
    console.log(`   - Usuários: ${await usuarioRepository.count()}`);
    console.log(`   - Competições: ${await competicaoRepository.count()}`);
    console.log(`   - Atletas: ${await atletaRepository.count()}`);
    console.log(`   - Testes: ${await testeRepository.count()}`);
    console.log(`   - Amostras: ${await amostraRepository.count()}`);
    console.log(`   - Resultados: ${await resultadoRepository.count()}`);

    console.log('\n🔐 Usuários criados:');
    console.log('   - admin@cbf.com.br / admin123 (CBF)');
    console.log('   - lab@teste.com.br / lab123 (LABORATORIO)');
    console.log('   - federacao@fpf.com.br / fpf123 (FEDERACAO)');
  } catch (error) {
    console.error('❌ Erro ao executar seed:', error);
    throw error;
  } finally {
    await dataSource.destroy();
  }
}

// Executar seed se chamado diretamente
if (require.main === module) {
  seedDatabase()
    .then(() => {
      console.log('\n✅ Seed executado com sucesso!');
      process.exit(0);
    })
    .catch((error) => {
      console.error('\n❌ Erro ao executar seed:', error);
      process.exit(1);
    });
}

export { seedDatabase };

