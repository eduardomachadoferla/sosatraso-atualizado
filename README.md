# 📘 Projeto SOS ATRASO

## 📌 Visão Geral

O **SOS ATRASO** é um sistema desenvolvido para **automatizar o registro de atrasos de alunos**, oferecendo à escola um controle interno mais eficiente e organizado.

Por meio de uma interface simples e intuitiva, os alunos registram seus atrasos ao chegarem na escola. O sistema captura informações como nome, turma, motivo do atraso e horário de entrada, gerando um **ticket impresso** que serve como comprovante.

---
## Figuima
https://www.figma.com/design/D95B1wbnaliC835eAI2tjW/Untitled?node-id=0-1&t=4GpDZRwwxpMmE7i0-1

---

## 🎯 Objetivos

- ✅ Automatizar o processo de registro de atrasos.
- ✅ Facilitar a comunicação entre recepção, coordenação e responsáveis.
- ✅ Gerar relatórios precisos e organizados.
- ✅ Proporcionar maior controle, transparência e segurança nos registros.

---

## 💡 Justificativa

Acompanhar a frequência dos alunos de forma precisa permite identificar padrões, antecipar problemas e tomar decisões assertivas. Isso contribui para um ambiente escolar mais saudável, promovendo apoio a alunos com dificuldades e evitando faltas recorrentes.

---

## 🛠️ Tecnologias Utilizadas

- 💻 Visual Studio Code
- 🐘 PHP 8
- 🛢️ MySQL
- 🌐 Apache
- 🎨 Figma
- 📚 Canvas LMS (para design e documentação)

---

## 📋 Funcionalidades Principais

- 📌 **Cadastro de Alunos**  
  Validação por número de carteirinha.

- ⏱️ **Registro de Atrasos**  
  Seleção de motivo com hora automática.

- 🔍 **Consulta de Atrasos**  
  Filtros por nome, turma e data.

- 📑 **Relatórios**  
  Exportação em PDF/CSV e agendamento automático.

- 🔐 **Login e Controle de Acesso**  
  Com níveis diferentes de acesso e autenticação em dois fatores.

- 📊 **Histórico e Gráficos**  
  Visualização dos dados por aluno.

- 📤 **Notificações** *(em estudo)*  
  Via SMS, e-mail ou WhatsApp para responsáveis e professores.

---

## 🔐 Gerar Senha de Administrador

Para criar a senha do primeiro administrador, execute o seguinte script PHP:

```php
<?php
$senha = 'admin'; // Substitua pela senha desejada
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>
