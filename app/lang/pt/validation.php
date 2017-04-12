<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	'accepted' => 'O campo :attribute deve ser aceito.',
	'active_url' => 'O campo :attribute não contem uma URL válida.',
	'after' => 'O campo :attribute deve ser uma data após :date.',
	'alpha' => 'O campo :attribute pode conter apenas letras.',
	'alpha_dash' => 'O campo :attribute pode conter apenas letras, números, e hífens.',
	'alpha_num' => 'O campo :attribute pode conter apenas letras e números.',
	'array' => 'O campo :attribute deve ser do tipo array.',
	'before' => 'O campo :attribute deve ser uma data antes de :date.',
	'between' => array(
		'numeric' => 'O campo :attribute deve estar entre :min e :max.',
		'file' => 'O campo :attribute deve estar entre :min e :max kilobytes.',
		'string' => 'O campo :attribute deve ter entre :min e :max caracteres.',
		'array' => 'O campo :attribute deve ter entre :min e :max itens.'
	),
	'confirmed' => 'A confirmação :attribute não está correta.',
	'date' => 'O campo :attribute não contém uma data válida.',
	'date_format' => 'O campo :attribute não está no formato :format.',
	'different' => 'O valor de :attribute e :other devem ser diferentes.',
	'digits' => 'O campo :attribute deve ter :digits digitos.',
	'digits_between' => 'O campo :attribute deve estar entre :min e :max digitos.',
	'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
	'exists' => 'O selecionado, :attribute, é inválido.',
	'image' => 'O campo :attribute deve ser uma imagem.',
	'in' => 'O :attribute selecionado é inválido.',
	'integer' => 'O campo :attribute deve ser um número inteiro.',
	'ip' => 'O campo :attribute deve conter um endereço de IP válido.',
	'max' => array(
		'numeric' => 'O campo :attribute não pode ser maior que :max.',
		'file' => 'O campo :attribute não pode ser maior que :max kilobytes.',
		'string' => 'O campo :attribute não pode conter mais de :max caracteres.',
		'array' => 'O campo :attribute não pode conter mais de :max itens.'
	),
	'mimes' => 'O campo :attribute deve ser um arquivo do tipo: :values.',
	'min' => array(
		'numeric' => 'O campo :attribute deve ser pelo menos :min.',
		'file' => 'O campo :attribute deve ser pelo menos :min kilobytes.',
		'string' => 'O campo :attribute deve conter pelo menos :min caracteres.',
		'array' => 'O campo :attribute deve conter pelo menos :min itens.'
	),
	'not_in' => 'O selecionado, :attribute, é invalido.',
	'numeric' => 'O campo :attribute deve ser um número.',
	'regex' => 'O formato de :attribute é inválido.',
	'required' => 'O campo :attribute é obrigatório.',
	'required_if' => 'O campo :attribute é requerido quando :other é :value.',
	'required_with' => 'O campo :attribute é requerido quando :values está presente.',
	'required_with_all' => 'O campo :attribute é requerido quando :values está presente.',
	'required_without' => 'O campo :attribute é requerido quando :values não está presente.',
	'required_without_all' => 'O campo :attribute é requerido quando nenhum dos :values estão presentes.',
	'same' => 'O campo :attribute e :other devem coincidir.',
	'size' => array(
		'numeric' => 'O campo :attribute deve ter :size.',
		'file' => 'O campo :attribute deve ter :size kilobytes.',
		'string' => 'O campo :attribute deve conter :size caracteres.',
		'array' => 'O campo :attribute deve conter :size itens.'
	),
	'unique' => 'O campo :attribute já foi cadastrado anteriormente.',
	'url' => 'O formato do campo :attribute é inválido.',

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention 'attribute.rule' to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'cpf' => 'O CPF digitado não é válido.',
	'cnpj' => 'O CNPJ informado não é válido.',
	'phone' => 'Número de telefone inválido no campo :attribute.',
	'phoneddd' => 'Número de telefone inválido no campo :attribute.',
	'cep' => ':attribute inválido.',
	'datebr' => 'Data no campo :attribute é inválida.',
	'hora24' => 'Hora no campo :attribute é inválida.',
	'hora_apos' => 'Hora inicial não pode ser maior que a hora final.',
	'data_apos' => 'Data inicial não pode ser maior que a data final.',
	'data_anterior' => 'Data final não pode ser menor que a data inicial.',
	'hour' => 'Horário do campo :attribute é inválido.',
	'custom' => array(
		// Empresa
		'razao' => array(
			'required_if' => 'O campo razão social é obrigatório.'
		),
		'nome' => array(
			'required_if' => 'O campo nome fantasia é obrigatório.'
		),
		'cnpj' => array(
			'required_if' => 'O campo CNPJ é obrigatório.'
		),
		'fundacao' => array(
			'required_if' => 'O campo fundação da empresa é obrigatório.',
			'datebr' => 'O campo fundação da empresa deve ser uma data.'
		),
		'setor' => array(
			'required_if' => 'Setor econômico é obrigatório.'
		),
		'negocio_principal' => array(
			'required_if' => 'Negócio principal obrigatório.'
		),
		'faturamento_2013' => array(
			'required_if' => 'Informe o faturamento em 2013.',
			'regex' => 'Faturamento em 2014 deve ser um valor em dinheiro.'
		),
		'categoria_operacional' => array(
			'required_if' => 'Estágio atual do negócio obrigatório.'
		),
		'faturamento_2014' => array(
			'required_if' => 'Informe o faturamento previsto para 2014.',
			'regex' => 'Faturamento em 2014 deve ser um valor em dinheiro.'
		),
		'ds_setor_outro' => array(
			'required_if' => 'Descreva o setor da sua empresa'
		),
		'investimento_valor_anjo' => array(
			'required_if' => 'Preencha o valor do investimento.',
			'regex' => 'Valor do investimento deve ser um valor em dinheiro.'
		),
		'investimento_valor_vc' => array(
			'required_if' => 'Preencha o valor do investimento.',
			'regex' => 'Valor do investimento deve ser um valor em dinheiro.'
		),
		'investimento_valor_outro' => array(
			'required_if' => 'Preencha o valor do investimento.',
			'regex' => 'Valor do investimento deve ser um valor em dinheiro.'
		),
		'investimento_dealhe_outro' => array(
			'required_if' => 'Descrição do investimento é obrigatória.'
		),
		'aceleradora' => array(
			'required_if' => 'O campo aceleradora é obrigatório.'
		),
		'incubadora' => array(
			'required_if' => 'O campo incubadora é obrigatório.'
		),
		'meses_operacional' => array(
			'required_if' => 'Informe em quanto tempo seu negócio estará operacional.'
		),
		'pre_faturamento' => array(
			'required_if' => 'Informe o faturamento previsto para 2014.'
		),
		'setor_pre' => array(
			'required_if' => 'Informe o setor de atuação do seu negócio.'
		),
		// Usuario
		'nascimento' => array(
			'datebr' => 'Nascimento deve ser uma data.'
		),
		'escolaridade' => array(
			'in' => 'Escolaridade inválida'
		),
		'formacao' => 'in',
		'estado' => array(
			'in' => 'Estado inválido.'
		),
		'telefone' => array(
			'phoneddd' => 'Telefone celular inválido.'
		),
		'celular' => array(
			'phoneddd' => 'Telefone celular inválido.'
		)
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of 'email'. This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'ds_nome' => 'Nome',
		'ds_email' => 'E-Mail',
		'atual' => 'senha atual',
		'nova' => 'nova senha',
		'nova_confirmation' => 'confirmar senha'
	)
);