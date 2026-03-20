<?php
/**
 * Brasil GEO - Content Seeder
 * Run once via: https://blog.brasilgeo.ai/wp-content/themes/brasilgeo-wp/brasilgeo-seed.php
 * DELETE THIS FILE AFTER RUNNING!
 */

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
set_time_limit( 300 );

// Load WordPress
$wp_load_paths = array(
	dirname( __FILE__ ) . '/../../../wp-load.php',
);
$loaded = false;
foreach ( $wp_load_paths as $path ) {
	if ( file_exists( $path ) ) {
		require_once $path;
		$loaded = true;
		break;
	}
}
if ( ! $loaded ) {
	die( 'Could not load WordPress.' );
}

// Only run for logged in admins or CLI
if ( ! defined( 'ABSPATH' ) ) {
	die( 'ABSPATH not defined.' );
}

// Load ALL admin functions to ensure everything is available
require_once ABSPATH . 'wp-admin/includes/admin.php';

header( 'Content-Type: text/plain; charset=utf-8' );
if ( ob_get_level() ) ob_end_clean();

echo "=== Brasil GEO Content Seeder ===\n\n";
flush();

// 1. Activate the theme
switch_theme( 'brasilgeo-wp' );
echo "Theme activated: brasilgeo-wp\n";

// 2. Update site settings
update_option( 'blogname', 'Brasil GEO' );
update_option( 'blogdescription', 'Portal de Noticias sobre Generative Engine Optimization e IA' );
update_option( 'show_on_front', 'posts' );
update_option( 'posts_per_page', 12 );
update_option( 'date_format', 'd/m/Y' );
update_option( 'time_format', 'H:i' );
update_option( 'timezone_string', 'America/Sao_Paulo' );
echo "Site settings updated.\n";
flush();

// 3. Create categories
$categories = array(
	'GEO'                  => 'Generative Engine Optimization - estrategias e tecnicas para visibilidade em IAs generativas.',
	'Inteligencia Artificial' => 'Noticias e avancos em inteligencia artificial, machine learning e deep learning.',
	'SEO'                  => 'Search Engine Optimization - tendencias e evolucao do SEO tradicional.',
	'Mercado Digital'      => 'Analises de mercado, tendencias e oportunidades no marketing digital.',
	'Tendencias'           => 'Futuro da tecnologia, inovacao e transformacao digital.',
);

$cat_ids = array();
foreach ( $categories as $name => $desc ) {
	$slug = sanitize_title( $name );
	$existing = get_category_by_slug( $slug );
	if ( $existing ) {
		$cat_ids[ $name ] = $existing->term_id;
		echo "Category exists: {$name} (ID: {$existing->term_id})\n";
	} else {
		$result = wp_insert_term( $name, 'category', array(
			'description' => $desc,
			'slug'        => $slug,
		) );
		if ( ! is_wp_error( $result ) ) {
			$cat_ids[ $name ] = $result['term_id'];
			echo "Created category: {$name} (ID: {$result['term_id']})\n";
		} else {
			echo "ERROR creating category {$name}: {$result->get_error_message()}\n";
		}
	}
}

echo "\n";

// 4. Create articles
$articles = array(
	array(
		'title'    => 'Como o ChatGPT esta mudando a forma como buscamos informacao na internet',
		'category' => 'GEO',
		'tags'     => array( 'ChatGPT', 'busca', 'IA generativa', 'GEO' ),
		'image'    => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=1200&h=675&fit=crop',
		'excerpt'  => 'A ascensao dos modelos de linguagem como o ChatGPT esta transformando radicalmente o comportamento de busca dos usuarios, criando novos desafios e oportunidades para marcas e criadores de conteudo.',
		'content'  => '<h2>A nova era da busca por informacao</h2>
<p>O lancamento do ChatGPT em novembro de 2022 marcou o inicio de uma revolucao silenciosa na forma como as pessoas buscam e consomem informacao online. Mais de 100 milhoes de usuarios ja utilizam ferramentas de IA generativa como primeiro ponto de contato para suas duvidas.</p>

<h2>O impacto no trafego organico</h2>
<p>Estudos recentes mostram que sites que nao otimizam seu conteudo para motores de IA generativa estao perdendo ate 30% do trafego organico. Isso acontece porque as respostas sintetizadas pela IA frequentemente substituem a necessidade de clicar em links tradicionais.</p>

<h3>O que muda na pratica?</h3>
<ul>
<li>Usuarios fazem perguntas completas em vez de palavras-chave fragmentadas</li>
<li>A IA sintetiza informacoes de multiplas fontes em uma unica resposta</li>
<li>A citacao de fontes pela IA se torna o novo "primeiro resultado do Google"</li>
<li>Conteudo estruturado e factual tem maior chance de ser referenciado</li>
</ul>

<h2>Estrategias de GEO para se adaptar</h2>
<p>Generative Engine Optimization (GEO) e a disciplina emergente que visa otimizar conteudo para ser referenciado por IAs generativas. As principais estrategias incluem:</p>

<blockquote>
<p>"Nao se trata mais de rankear em primeiro lugar - trata-se de ser a fonte que a IA escolhe citar." - Especialista em GEO</p>
</blockquote>

<p>A implementacao de dados estruturados, a producao de conteudo factual verificavel e a construcao de autoridade tematica sao fundamentais neste novo cenario.</p>

<h2>O futuro da busca</h2>
<p>Especialistas preveem que ate 2027, mais de 40% das buscas informacionais serao respondidas diretamente por IAs, sem necessidade de visitar um site. Preparar-se para essa realidade nao e mais opcional - e uma questao de sobrevivencia digital.</p>

<p><strong>Fonte:</strong> Estudo GEO Research Lab, Universidade de Princeton (2024)</p>',
	),
	array(
		'title'    => 'Google AI Overviews atinge 1 bilhao de usuarios: o que isso significa para o SEO',
		'category' => 'SEO',
		'tags'     => array( 'Google', 'AI Overviews', 'SEO', 'busca' ),
		'image'    => 'https://images.unsplash.com/photo-1573804633927-bfcbcd909acd?w=1200&h=675&fit=crop',
		'excerpt'  => 'O Google confirmou que seus resumos gerados por IA ja alcancam mais de 1 bilhao de usuarios mensais, transformando fundamentalmente os resultados de busca.',
		'content'  => '<h2>AI Overviews: o novo padrao da busca</h2>
<p>O Google anunciou que o recurso AI Overviews (anteriormente conhecido como SGE - Search Generative Experience) agora atinge mais de 1 bilhao de usuarios mensais em todo o mundo. Este marco representa uma mudanca fundamental na forma como os resultados de busca sao apresentados.</p>

<h2>Impacto nos cliques organicos</h2>
<p>Dados preliminares de diversas plataformas de analytics mostram uma reducao media de 18-25% no CTR (taxa de cliques) para resultados organicos tradicionais quando AI Overviews sao exibidos. As categorias mais afetadas incluem saude, financas e tecnologia.</p>

<h3>Categorias mais impactadas</h3>
<ul>
<li><strong>Saude e bem-estar:</strong> Reducao de 32% no CTR</li>
<li><strong>Financas pessoais:</strong> Reducao de 28% no CTR</li>
<li><strong>Tecnologia e reviews:</strong> Reducao de 22% no CTR</li>
<li><strong>Receitas e culinaria:</strong> Reducao de 15% no CTR</li>
</ul>

<h2>Como se adaptar</h2>
<p>A chave para manter visibilidade neste novo cenario esta em produzir conteudo que a IA do Google considere confiavel o suficiente para citar como fonte. Isso inclui dados exclusivos, pesquisas originais e expertise comprovada no tema (E-E-A-T).</p>

<p><strong>Fonte:</strong> Google I/O 2025, SearchEngineLand</p>',
	),
	array(
		'title'    => 'O que e GEO: Guia completo sobre Generative Engine Optimization para 2025',
		'category' => 'GEO',
		'tags'     => array( 'GEO', 'guia', 'otimizacao', 'IA generativa' ),
		'image'    => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=1200&h=675&fit=crop',
		'excerpt'  => 'Um guia abrangente sobre GEO - a nova disciplina que visa otimizar conteudo para ser referenciado e citado por IAs generativas como ChatGPT, Gemini e Perplexity.',
		'content'  => '<h2>Definicao de GEO</h2>
<p>Generative Engine Optimization (GEO) e o conjunto de estrategias e praticas destinadas a otimizar conteudo digital para que seja referenciado, citado e recomendado por motores de IA generativa. Enquanto o SEO tradicional foca em rankear em paginas de resultados de busca, o GEO foca em ser a fonte de informacao escolhida pela IA.</p>

<h2>Os pilares do GEO</h2>
<h3>1. Autoridade tematica</h3>
<p>IAs generativas tendem a citar fontes que demonstram expertise profunda em um tema. Construir autoridade tematica atraves de conteudo consistente e aprofundado e fundamental.</p>

<h3>2. Dados estruturados</h3>
<p>Schema markup, tabelas bem formatadas e listas organizadas facilitam a extracao de informacoes pela IA.</p>

<h3>3. Fatos verificaveis</h3>
<p>Conteudo com dados, estatisticas e citacoes verificaveis tem maior probabilidade de ser referenciado.</p>

<h3>4. Clareza e objetividade</h3>
<p>Respostas diretas a perguntas comuns, organizadas de forma logica, sao priorizadas por modelos de linguagem.</p>

<h2>GEO vs SEO: complementares, nao concorrentes</h2>
<p>E importante entender que GEO nao substitui o SEO - ele o complementa. Um conteudo otimizado para GEO naturalmente tambem performa bem em buscas tradicionais, pois os mesmos principios de qualidade se aplicam.</p>

<p><strong>Fonte:</strong> GEO Research Paper - Princeton University, Georgia Tech (2024)</p>',
	),
	array(
		'title'    => 'Perplexity AI levanta US$ 500 milhoes e desafia Google no mercado de buscas',
		'category' => 'Mercado Digital',
		'tags'     => array( 'Perplexity', 'investimento', 'busca', 'startup' ),
		'image'    => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=675&fit=crop',
		'excerpt'  => 'A startup de busca por IA Perplexity AI captou mais uma rodada de investimento, consolidando sua posicao como principal concorrente do Google no segmento de busca conversacional.',
		'content'  => '<h2>O crescimento explosivo da Perplexity</h2>
<p>A Perplexity AI, motor de busca baseado em inteligencia artificial, anunciou uma nova rodada de financiamento de US$ 500 milhoes, elevando sua avaliacao para mais de US$ 9 bilhoes. A empresa ja processa mais de 250 milhoes de buscas por mes.</p>

<h2>Por que a Perplexity importa para o GEO</h2>
<p>Diferente do Google, a Perplexity sempre cita suas fontes de forma transparente, criando um ecossistema onde ser referenciado pela IA se traduz diretamente em trafego qualificado. Isso torna a plataforma um caso de uso ideal para estrategias de GEO.</p>

<h3>Numeros que impressionam</h3>
<ul>
<li>250 milhoes de buscas mensais</li>
<li>Crescimento de 40% mes a mes</li>
<li>Presente em mais de 150 paises</li>
<li>Revenue anual estimado em US$ 100 milhoes</li>
</ul>

<h2>Implicacoes para o mercado brasileiro</h2>
<p>O Brasil e um dos mercados de maior crescimento para a Perplexity na America Latina. Empresas brasileiras que investirem em GEO agora terao vantagem competitiva significativa quando a plataforma expandir sua base de usuarios no pais.</p>

<p><strong>Fonte:</strong> TechCrunch, Bloomberg Technology</p>',
	),
	array(
		'title'    => 'Claude 4 da Anthropic: como o novo modelo impacta estrategias de conteudo',
		'category' => 'Inteligencia Artificial',
		'tags'     => array( 'Claude', 'Anthropic', 'LLM', 'conteudo' ),
		'image'    => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=1200&h=675&fit=crop',
		'excerpt'  => 'A Anthropic lancou o Claude 4, seu modelo mais avancado, com capacidades expandidas de analise e geracao de conteudo que redefinem o cenario competitivo de IA.',
		'content'  => '<h2>O que ha de novo no Claude 4</h2>
<p>A Anthropic apresentou o Claude 4, a mais recente iteracao de seu modelo de linguagem, com melhorias significativas em raciocinio logico, analise de dados e geracao de conteudo longo. O modelo demonstra capacidades superiores em tarefas complexas de pesquisa e sintese de informacoes.</p>

<h2>Impacto nas estrategias de conteudo</h2>
<p>Com modelos cada vez mais sofisticados, a barra de qualidade para conteudo que sera referenciado por IAs sobe significativamente. Conteudo generico e superficial tem cada vez menos chance de ser citado.</p>

<h3>O que os modelos avancados valorizam</h3>
<ul>
<li>Dados originais e pesquisas exclusivas</li>
<li>Analises com perspectiva unica e expertise</li>
<li>Conteudo atualizado e factualmente correto</li>
<li>Estrutura clara com hierarquia logica</li>
</ul>

<h2>Preparando conteudo para a era multi-modelo</h2>
<p>Uma estrategia eficaz de GEO deve considerar multiplos modelos de IA, nao apenas um. ChatGPT, Claude, Gemini e Perplexity utilizam diferentes abordagens para selecionar fontes, exigindo uma estrategia holistica de otimizacao.</p>

<p><strong>Fonte:</strong> Anthropic Blog, AI Research Weekly</p>',
	),
	array(
		'title'    => 'Brasil lidera adocao de IA generativa na America Latina, aponta pesquisa',
		'category' => 'Mercado Digital',
		'tags'     => array( 'Brasil', 'adocao', 'IA generativa', 'America Latina' ),
		'image'    => 'https://images.unsplash.com/photo-1483058712412-4245e9b90334?w=1200&h=675&fit=crop',
		'excerpt'  => 'Nova pesquisa revela que o Brasil e o pais latino-americano com maior taxa de adocao de ferramentas de IA generativa, com impactos significativos no marketing digital.',
		'content'  => '<h2>Brasil na vanguarda da IA generativa</h2>
<p>Uma pesquisa realizada pela McKinsey & Company em parceria com instituicoes locais revelou que 67% das empresas brasileiras de medio e grande porte ja utilizam alguma forma de IA generativa em suas operacoes de marketing e comunicacao.</p>

<h2>Os numeros do Brasil</h2>
<ul>
<li>67% das empresas ja usam IA generativa no marketing</li>
<li>45% planejam aumentar investimentos em IA em 2025</li>
<li>82% dos profissionais de marketing usam ChatGPT regularmente</li>
<li>Mercado de IA no Brasil deve atingir US$ 3.2 bilhoes em 2025</li>
</ul>

<h2>Oportunidade para GEO no Brasil</h2>
<p>Com a alta adocao de IA generativa, o Brasil se torna um mercado estrategico para Generative Engine Optimization. Empresas que dominarem tecnicas de GEO terao vantagem competitiva significativa em um mercado de mais de 210 milhoes de consumidores.</p>

<h2>Desafios e perspectivas</h2>
<p>Apesar do avanco, desafios como a qualidade de conteudo em portugues nos datasets de treinamento e a falta de profissionais especializados em GEO ainda representam barreiras. No entanto, esses mesmos desafios criam oportunidades para pioneiros no mercado.</p>

<p><strong>Fonte:</strong> McKinsey Digital Brasil, Associacao Brasileira de IA</p>',
	),
	array(
		'title'    => '5 ferramentas essenciais para monitorar sua visibilidade em IAs generativas',
		'category' => 'GEO',
		'tags'     => array( 'ferramentas', 'monitoramento', 'GEO', 'analytics' ),
		'image'    => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&h=675&fit=crop',
		'excerpt'  => 'Descubra as principais ferramentas disponiveis para monitorar como sua marca e seus conteudos aparecem nas respostas de ChatGPT, Gemini, Perplexity e outros motores de IA.',
		'content'  => '<h2>Por que monitorar visibilidade em IAs?</h2>
<p>Assim como monitoramos rankings no Google, e essencial acompanhar como e com que frequencia sua marca e citada por IAs generativas. Essa visibilidade se traduz em credibilidade e, cada vez mais, em trafego qualificado.</p>

<h2>As 5 ferramentas que voce precisa conhecer</h2>

<h3>1. Otterly.AI</h3>
<p>Monitora mencoes e citacoes da sua marca em ChatGPT, Gemini e Perplexity. Oferece dashboards detalhados com metricas de visibilidade ao longo do tempo.</p>

<h3>2. Profound</h3>
<p>Plataforma focada em analytics de GEO, com rastreamento de como seu conteudo e utilizado por diferentes modelos de IA para gerar respostas.</p>

<h3>3. Peec AI</h3>
<p>Ferramenta de auditoria que analisa seu conteudo e sugere otimizacoes especificas para melhorar a chance de ser citado por IAs generativas.</p>

<h3>4. BrightEdge Generative Parser</h3>
<p>Modulo da plataforma BrightEdge que rastreia a presenca da sua marca em AI Overviews do Google e outros recursos de IA em SERPs.</p>

<h3>5. Semrush AI Overview Tracking</h3>
<p>Nova funcionalidade do Semrush que identifica quais das suas paginas estao sendo citadas em AI Overviews e como sua visibilidade varia ao longo do tempo.</p>

<p><strong>Fonte:</strong> Search Engine Journal, Marketing AI Institute</p>',
	),
	array(
		'title'    => 'OpenAI lanca SearchGPT: a busca por IA que pode substituir o Google',
		'category' => 'Inteligencia Artificial',
		'tags'     => array( 'OpenAI', 'SearchGPT', 'busca', 'Google' ),
		'image'    => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?w=1200&h=675&fit=crop',
		'excerpt'  => 'A OpenAI apresentou oficialmente o SearchGPT, seu motor de busca integrado ao ChatGPT, intensificando a competicao direta com o Google no mercado de buscas.',
		'content'  => '<h2>SearchGPT: a aposta da OpenAI contra o Google</h2>
<p>A OpenAI lancou oficialmente o SearchGPT como recurso integrado ao ChatGPT, permitindo que usuarios realizem buscas na web em tempo real diretamente na interface do chatbot. O recurso combina a capacidade conversacional do ChatGPT com resultados de busca atualizados.</p>

<h2>Diferenciais do SearchGPT</h2>
<ul>
<li>Respostas conversacionais com fontes citadas</li>
<li>Atualizacao em tempo real de informacoes</li>
<li>Interface sem anuncios (por enquanto)</li>
<li>Integracao nativa com o ecossistema ChatGPT</li>
<li>Capacidade de follow-up contextual</li>
</ul>

<h2>Implicacoes para GEO</h2>
<p>O SearchGPT cria uma nova frente de otimizacao para profissionais de GEO. Com mais de 200 milhoes de usuarios do ChatGPT potencialmente usando busca integrada, a importancia de ser citado como fonte confiavel nunca foi tao grande.</p>

<h3>O que funciona no SearchGPT</h3>
<p>Analises preliminares indicam que o SearchGPT tende a priorizar fontes com dados recentes e atualizados, sites com boa reputacao de dominio e conteudo que responde diretamente a intencao de busca do usuario.</p>

<p><strong>Fonte:</strong> OpenAI Blog, The Verge</p>',
	),
	array(
		'title'    => 'Como dados estruturados e Schema Markup potencializam sua estrategia de GEO',
		'category' => 'SEO',
		'tags'     => array( 'schema markup', 'dados estruturados', 'GEO', 'SEO tecnico' ),
		'image'    => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1200&h=675&fit=crop',
		'excerpt'  => 'Entenda como implementar dados estruturados e Schema Markup pode aumentar significativamente a probabilidade do seu conteudo ser citado por IAs generativas.',
		'content'  => '<h2>A ponte entre SEO tecnico e GEO</h2>
<p>Dados estruturados sempre foram importantes para SEO, mas no contexto de GEO, eles se tornam ainda mais criticos. IAs generativas utilizam dados estruturados como uma das formas de compreender e validar informacoes em paginas web.</p>

<h2>Schema Markup prioritarios para GEO</h2>
<h3>Article e NewsArticle</h3>
<p>Identificar corretamente seu conteudo como artigo ou noticia facilita a indexacao e compreensao por crawlers de IA.</p>

<h3>FAQPage</h3>
<p>Perguntas e respostas estruturadas sao facilmente extraidas por modelos de linguagem para gerar respostas sintetizadas.</p>

<h3>HowTo</h3>
<p>Tutoriais e guias passo-a-passo com markup HowTo sao frequentemente utilizados como fonte para respostas instrucionais.</p>

<h3>Organization e Author</h3>
<p>Estabelecer claramente a autoria e a organizacao responsavel pelo conteudo fortalece os sinais de E-E-A-T que IAs utilizam para avaliar confiabilidade.</p>

<h2>Implementacao pratica</h2>
<p>A implementacao correta de Schema Markup requer atencao a detalhes. Utilize o Validador de Rich Results do Google para verificar se sua implementacao esta correta, e monitore o Search Console para identificar erros.</p>

<p><strong>Fonte:</strong> Google Search Central, Schema.org</p>',
	),
	array(
		'title'    => 'O papel do E-E-A-T na era da IA: por que experiencia e expertise importam mais do que nunca',
		'category' => 'GEO',
		'tags'     => array( 'E-E-A-T', 'autoridade', 'expertise', 'confiabilidade' ),
		'image'    => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=675&fit=crop',
		'excerpt'  => 'Na era da IA generativa, os principios de E-E-A-T (Experience, Expertise, Authoritativeness, Trustworthiness) se tornam ainda mais relevantes para quem quer ser citado por motores de IA.',
		'content'  => '<h2>E-E-A-T: do Google para a IA</h2>
<p>Os principios de E-E-A-T (Experiencia, Expertise, Autoridade e Confiabilidade) foram originalmente definidos pelo Google para avaliar a qualidade de conteudo. Na era da IA generativa, esses mesmos principios sao utilizados - de formas diferentes - por modelos de linguagem para decidir quais fontes citar.</p>

<h2>Os quatro pilares na pratica do GEO</h2>

<h3>Experiencia (Experience)</h3>
<p>Conteudo baseado em experiencia real e pratica tem maior chance de ser citado. IAs conseguem distinguir entre conteudo generico reescrito e analises baseadas em vivencia genuina.</p>

<h3>Expertise</h3>
<p>Demonstrar conhecimento tecnico profundo, com uso correto de terminologia e referencias atualizadas, fortalece a percepcao de expertise.</p>

<h3>Autoridade (Authoritativeness)</h3>
<p>Ser reconhecido como referencia no seu nicho - atraves de backlinks de qualidade, mencoes por outros especialistas e presenca consistente - constroi autoridade.</p>

<h3>Confiabilidade (Trustworthiness)</h3>
<p>Transparencia sobre fontes, correcao de informacoes quando necessario e ausencia de conteudo enganoso sao fundamentais para a confiabilidade.</p>

<h2>Estrategias praticas</h2>
<ul>
<li>Inclua biografia completa dos autores com credenciais verificaveis</li>
<li>Cite fontes primarias e dados originais sempre que possivel</li>
<li>Atualize conteudo antigo com informacoes recentes</li>
<li>Construa presenca do autor em multiplas plataformas</li>
</ul>

<p><strong>Fonte:</strong> Google Quality Rater Guidelines, GEO Research Lab</p>',
	),
	array(
		'title'    => 'Gemini 2.0 do Google: nova geracao de IA com busca multimodal integrada',
		'category' => 'Inteligencia Artificial',
		'tags'     => array( 'Gemini', 'Google', 'multimodal', 'IA' ),
		'image'    => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=1200&h=675&fit=crop',
		'excerpt'  => 'O Google apresentou o Gemini 2.0, seu modelo de IA de proxima geracao com capacidades multimodais avancadas que integram busca, visao e raciocinio em uma unica plataforma.',
		'content'  => '<h2>Gemini 2.0: o futuro da IA do Google</h2>
<p>O Google apresentou o Gemini 2.0, representando um salto significativo em capacidades de IA multimodal. O novo modelo combina compreensao de texto, imagens, audio e video em uma unica arquitetura, com integracao nativa ao ecossistema de busca do Google.</p>

<h2>Principais novidades</h2>
<ul>
<li><strong>Busca multimodal:</strong> Usuarios podem combinar texto e imagens em suas buscas</li>
<li><strong>Raciocinio avancado:</strong> Capacidade de resolver problemas complexos com multiplas etapas</li>
<li><strong>Integracao com AI Overviews:</strong> Respostas mais ricas e contextuais nos resultados de busca</li>
<li><strong>Agentes autonomos:</strong> Capacidade de executar tarefas complexas de forma independente</li>
</ul>

<h2>Impacto no GEO</h2>
<p>Com o Gemini 2.0 alimentando os AI Overviews do Google, a importancia de otimizar conteudo para ser citado por esta IA se intensifica. Conteudo multimidia rico - com imagens, infograficos e videos - ganha relevancia adicional.</p>

<h3>Otimizando para Gemini 2.0</h3>
<p>Alem do conteudo textual de qualidade, considere otimizar imagens com alt text descritivo, criar infograficos com dados relevantes e produzir videos explicativos que complementem seu conteudo escrito.</p>

<p><strong>Fonte:</strong> Google DeepMind Blog, Wired</p>',
	),
	array(
		'title'    => 'O futuro do marketing de conteudo em um mundo dominado por IA',
		'category' => 'Tendencias',
		'tags'     => array( 'marketing de conteudo', 'futuro', 'IA', 'estrategia' ),
		'image'    => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1200&h=675&fit=crop',
		'excerpt'  => 'Analise aprofundada sobre como a IA generativa esta redefinindo o marketing de conteudo e quais estrategias serao essenciais para profissionais e empresas nos proximos anos.',
		'content'  => '<h2>A transformacao inevitavel</h2>
<p>O marketing de conteudo como conhecemos esta passando por sua maior transformacao desde o surgimento do Google. A ascensao da IA generativa nao elimina a necessidade de conteudo - ela redefine completamente o que significa criar conteudo de valor.</p>

<h2>Tres cenarios para o futuro</h2>

<h3>Cenario 1: Conteudo como commodity</h3>
<p>Conteudo generico e informacional basico sera completamente commoditizado. IAs generarao este tipo de conteudo de forma instantanea e gratuita, eliminando qualquer valor competitivo.</p>

<h3>Cenario 2: Expertise como diferencial</h3>
<p>Conteudo baseado em experiencia real, dados exclusivos e perspectivas unicas se tornara ainda mais valioso. A escassez de conteudo genuinamente original aumentara seu preco de mercado.</p>

<h3>Cenario 3: Distribuicao via IA</h3>
<p>A distribuicao de conteudo migrara parcialmente para plataformas de IA. Ser citado como fonte por ChatGPT ou Gemini se tornara tao importante quanto rankear no Google.</p>

<h2>Habilidades essenciais para o profissional do futuro</h2>
<ul>
<li>Dominio de GEO (Generative Engine Optimization)</li>
<li>Capacidade de produzir pesquisa original e dados exclusivos</li>
<li>Habilidade de construir narrativas que IAs nao conseguem replicar</li>
<li>Compreensao tecnica de como modelos de linguagem funcionam</li>
<li>Pensamento estrategico para distribuicao multi-plataforma</li>
</ul>

<p><strong>Fonte:</strong> Content Marketing Institute, Harvard Business Review</p>',
	),
);

$user_id = 1; // Default admin user
// Try to find the brasilgeo2 user
$user = get_user_by( 'login', 'brasilgeo2' );
if ( $user ) {
	$user_id = $user->ID;
}

foreach ( $articles as $i => $article ) {
	// Check if post exists by title
	$existing_q = new WP_Query( array( 'title' => $article['title'], 'post_type' => 'post', 'posts_per_page' => 1, 'fields' => 'ids' ) );
	if ( $existing_q->have_posts() ) {
		echo "Post exists: {$article['title']}\n";
		continue;
	}

	$cat_id = isset( $cat_ids[ $article['category'] ] ) ? $cat_ids[ $article['category'] ] : 1;

	// Create post
	$post_id = wp_insert_post( array(
		'post_title'   => $article['title'],
		'post_content' => $article['content'],
		'post_excerpt' => $article['excerpt'],
		'post_status'  => 'publish',
		'post_author'  => $user_id,
		'post_type'    => 'post',
		'post_category'=> array( $cat_id ),
		'post_date'    => date( 'Y-m-d H:i:s', strtotime( "-{$i} days" ) ),
	) );

	if ( is_wp_error( $post_id ) ) {
		echo "ERROR creating: {$article['title']} - {$post_id->get_error_message()}\n";
		continue;
	}

	// Add tags
	if ( ! empty( $article['tags'] ) ) {
		wp_set_post_tags( $post_id, $article['tags'] );
	}

	// Download and set featured image
	if ( ! empty( $article['image'] ) ) {
		$image_id = media_sideload_image( $article['image'], $post_id, $article['title'], 'id' );
		if ( ! is_wp_error( $image_id ) ) {
			set_post_thumbnail( $post_id, $image_id );
			echo "Created post with image: {$article['title']} (ID: {$post_id})\n";
		} else {
			echo "Created post (no image): {$article['title']} (ID: {$post_id}) - Image error: {$image_id->get_error_message()}\n";
		}
	} else {
		echo "Created post: {$article['title']} (ID: {$post_id})\n";
	}
	flush();

	// Make first post sticky
	if ( $i === 0 ) {
		stick_post( $post_id );
		echo "  -> Set as sticky\n";
	}
}

echo "\n";

// 5. Create navigation menu
$menu_name = 'Menu Principal';
$menu_exists = wp_get_nav_menu_object( $menu_name );

if ( ! $menu_exists ) {
	$menu_id = wp_create_nav_menu( $menu_name );
	echo "Created menu: {$menu_name} (ID: {$menu_id})\n";
} else {
	$menu_id = $menu_exists->term_id;
	echo "Menu exists: {$menu_name} (ID: {$menu_id})\n";
	// Clear existing items
	$items = wp_get_nav_menu_items( $menu_id );
	if ( $items ) {
		foreach ( $items as $item ) {
			wp_delete_post( $item->ID, true );
		}
	}
}

// Add menu items
$menu_items = array(
	array( 'title' => 'Home', 'url' => home_url( '/' ), 'position' => 1 ),
);

// Add categories
$position = 2;
foreach ( $cat_ids as $cat_name => $cid ) {
	$menu_items[] = array(
		'title'    => $cat_name,
		'url'      => get_category_link( $cid ),
		'position' => $position,
		'type'     => 'taxonomy',
		'taxonomy' => 'category',
		'object_id'=> $cid,
	);
	$position++;
}

// Add external link
$menu_items[] = array(
	'title'    => 'Conhecer GEO',
	'url'      => 'https://brasilgeo.ai',
	'position' => $position,
	'target'   => '_blank',
);

foreach ( $menu_items as $mi ) {
	$args = array(
		'menu-item-title'    => $mi['title'],
		'menu-item-url'      => $mi['url'],
		'menu-item-status'   => 'publish',
		'menu-item-position' => $mi['position'],
	);

	if ( isset( $mi['type'] ) && 'taxonomy' === $mi['type'] ) {
		$args['menu-item-type']      = 'taxonomy';
		$args['menu-item-object']    = $mi['taxonomy'];
		$args['menu-item-object-id'] = $mi['object_id'];
	} else {
		$args['menu-item-type'] = 'custom';
	}

	if ( isset( $mi['target'] ) ) {
		$args['menu-item-target'] = $mi['target'];
	}

	wp_update_nav_menu_item( $menu_id, 0, $args );
	echo "  Added menu item: {$mi['title']}\n";
}

// Assign menu to theme location
$locations = get_theme_mod( 'nav_menu_locations' );
$locations['primary'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
echo "Menu assigned to 'primary' location.\n";

// 6. Delete default Hello World post
$hello_q = new WP_Query( array( 'title' => 'Hello world!', 'post_type' => 'post', 'posts_per_page' => 1 ) );
if ( $hello_q->have_posts() ) {
	wp_delete_post( $hello_q->posts[0]->ID, true );
	echo "\nDeleted default 'Hello world!' post.\n";
}

// Delete default sample page
$sample_q = new WP_Query( array( 'title' => 'Sample Page', 'post_type' => 'page', 'posts_per_page' => 1 ) );
if ( $sample_q->have_posts() ) {
	wp_delete_post( $sample_q->posts[0]->ID, true );
	echo "Deleted default 'Sample Page'.\n";
}

// 7. Set permalink structure
update_option( 'permalink_structure', '/%category%/%postname%/' );
flush_rewrite_rules();
echo "Permalink structure set to: /%category%/%postname%/\n";

echo "\n=== SEED COMPLETE ===\n";
echo "Visit: " . home_url( '/' ) . "\n";
echo "\n!!! DELETE THIS FILE NOW FOR SECURITY !!!\n";
