1. (OK) Utilizar o League Plates para ter o template e as sessões de conteúdos e scripts (separar essas camadas).
2. Implementar componente Cropper
	a. (OK) Instalar componente cropper da coffeecode.
	b. (OK) Criar classe Thumb dentro do Source\Support
	c. (OK) Atributos privados: $cropper, $uploads
	d. (OK) $Construtor: o cropper instancia o componente (cachePath, imageQualityjpg - jpg 75 e png 5, imageQualitypng), uploads recebe o caminho para upload.
	e. (OK) Função Make (image, width e height). Executar a função make do componente (atenção aos caminhos das imagens)
	f. (OK) Função Flush(?string $image). Se tiver uma imagem, dou flush na imagem. Senão, flush geral. return (void_
	g. (OK) Função cropper para acessar a propriedade cropper.
	h. Testar abstração do componente.

3. Layout - Página Principal
	a. Banner com três imagens (banner em javascript)
	b. Sobre a barbearia (um pouco da história)
	c. Destacar três principais atributos
	d. Sistema de agendamento e fidelização: benefícios ao cliente
	e. Confira nossos produtos e serviços

4. Implementar componente uploader


Oportunidades de Melhoria
1. Rodar o minify de tempos em tempos.
2. Menu fixo ao dar scroll

