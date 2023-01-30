# Laravel DDD CQRS EDA StartKit

## Ajustes e melhorias

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas nas seguintes tarefas:

- [ ] `<task>`

## 💻 Pré-requisitos

Antes de começar, verifique se você atendeu aos seguintes requisitos:

- Você instalou a versão `php 8.1` ou superior
- Você instalou a versão mais recente de `Docker`
- Você tem uma máquina `<Windows / Linux / Mac>`

## ☕ Clonando e Instalando `<laravel-starkit>`

Para clonar o repositório `<laravel-starkit>`, siga estas etapas:

```bash
git clone git@gitlab.fretebras.com.br:fretepago/poc-cqrs-eda-laravel-ddd-ecotone.git
```

Conceder permissão de escrita para o diretório `storage` e `bootstrap/cache`:

```bash
chmod -R 777 storage bootstrap/cache
```

Para realizar a build e instalar as dependências `<laravel-starkit>`, siga estas etapas:

```bash
make build
```

## ⚙️ Configurando ambiente `<laravel-starkit>`

Utilizar o arquivo `.env.example` como base para a criação dos seguintes arquivos de configuração:

- `.env`
- `test.env`

## 🚀 Usando `<laravel-starkit>`

Para usar `<laravel-starkit>`, siga estas etapas:

```bash
make up
```

## Testes

```bash
# unit tests
$ make test

# lint
$ make lint-fix

# test coverage
$ make coverage-html
```

## Gerando arquivo de change log

```bash
npm changelog # only changelog file
npm changelog:minor # x.y.x
npm changelog:major # y.x.x
npm changelog:patch # x.x.y
npm changelog:alpha # x.x.x-alpha.0
```
