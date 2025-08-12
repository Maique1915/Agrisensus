<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Produtore $produtor
 */
?>
<?= $this->Html->css(['view']) ?>

<!-- Cabeçalho -->
<div class="header">
    <h1><?= h($produtor->nome) ?></h1>
    <p>Visualização completa dos dados cadastrados.</p>
</div>

<div class="produtores-list-container">
    <!-- Dados Pessoais com Ações -->
    <div class="details-card">
        <div class="card-header-actions">
            <h3 class="card-title">Dados Pessoais</h3>
            <div class="info-card-actions">
                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'Produtores', 'action' => 'edit', $produtor->id], ['class' => 'btn-action btn-edit', 'title' => 'Editar Produtor', 'escape' => false]) ?>
            </div>
        </div>
        <div class="details-grid">
            <div><strong>CPF:</strong> <span><?= h($produtor->cpf) ?: 'N/A' ?></span></div>
            <div><strong>CNPJ:</strong> <span><?= h($produtor->cnpj) ?: 'N/A' ?></span></div>
            <div><strong>Telefone:</strong> <span><?= h($produtor->telefone) ?: 'N/A' ?></span></div>
        </div>
    </div>

    <!-- Propriedades -->
    <?php if (!empty($produtor->propriedades)): ?>
        <div class="details-card">
            <h3 class="card-title">Propriedades</h3>
            <div class="card-grid">
                <?php foreach ($produtor->propriedades as $prop): ?>
                    <div class="info-card">
                        <div class="card-header-actions">
                            <h4 class="info-card-title"><?= h($prop->nome_propriedade) ?: 'Propriedade sem nome' ?></h4>
                            <div class="info-card-actions">
                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'Propriedades', 'action' => 'edit', $prop->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Propriedade', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-trash"></i>',
                                    '#',
                                    [
                                        'class' => 'btn-action btn-delete js-delete-propriedade-link',
                                        'title' => 'Excluir Propriedade',
                                        'escape' => false,
                                        'data-entity-id' => $prop->id,
                                        'data-entity-name' => h($prop->nome_propriedade) ?: 'Propriedade sem nome',
                                        'data-controller' => 'Propriedades',
                                        'data-url' => $this->Url->build(['controller' => 'Propriedades', 'action' => 'delete', $prop->id, '?' => ['id_produtor' => $produtor->id]])
                                    ]
                                ) ?>
                            </div>
                            <!-- Relação com a Propriedade -->
                        </div>
                        <!-- form oculto para exclusão -->
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'Propriedades', 'action' => 'delete', $prop->id],
                            'id' => 'delete-form-propriedade-' . $prop->id,
                            'style' => 'display:none;'
                        ]) ?>
                        <?= $this->Form->hidden('id_produtor', ['value' => $produtor->id]) ?>
                        <?= $this->Form->hidden('redirect_to', ['value' => 'produtor_view']) ?>
                        <?= $this->Form->end() ?>

                        <?php if (!empty($prop->relacao_propriedade)): ?>
                            <p><strong>Relação:</strong> <span><?= h($prop->relacao_propriedade) ?></span></p>
                        <?php endif; ?>

                        <!-- Terreno no nome do produtor -->
                        <p><strong>Terreno no nome do produtor:</strong> <span><?= $prop->terreno ? 'Sim' : 'Não' ?></span>
                        </p>

                        <!-- Área -->
                        <?php if (!empty($prop->area_total) && !empty($prop->unidade)): ?>
                            <p><strong>Área:</strong> <span><?= h($prop->area_total) . ' ' . h($prop->unidade) ?></span></p>
                        <?php endif; ?>

                        <!-- Endereço Completo -->
                        <p><strong>Endereço:</strong></p>
                        <div class="address-block">
                            <?php
                            // Constrói o endereço parte por parte para evitar vírgulas extras
                            $endereco = [];
                            if (!empty($prop->bairro))
                                $endereco[] = h($prop->bairro);
                            if (!empty($prop->cidade))
                                $endereco[] = h($prop->cidade);
                            if (!empty($prop->estado))
                                $endereco[] = h($prop->estado);

                            echo implode(', ', $endereco);

                            if (!empty($prop->numero))
                                echo ' - Nº ' . h($prop->numero);
                            if (!empty($prop->cep))
                                echo '<br>CEP: ' . h($prop->cep);
                            ?>
                        </div>

                        <!-- Comunidade e Localidade -->
                        <?php if (!empty($prop->comunidade)): ?>
                            <p><strong>Comunidade:</strong> <span><?= h($prop->comunidade) ?></span></p>
                        <?php endif; ?>
                        <?php if (!empty($prop->localidade)): ?>
                            <p><strong>Localidade:</strong> <span><?= h($prop->localidade) ?></span></p>
                        <?php endif; ?>

                        <!-- Complemento -->
                        <?php if (!empty($prop->complemento)): ?>
                            <p><strong>Complemento:</strong> <span><?= h($prop->complemento) ?></span></p>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Produtos Cultivados -->
    <?php if (!empty($produtor->produtos_cultivados)): ?>
        <div class="details-card">
            <h3 class="card-title">Produtos Cultivados</h3>
            <div class="card-grid">
                <?php foreach ($produtor->produtos_cultivados as $cultivo): ?>
                    <div class="info-card">
                        <div class="card-header-actions">
                            <h4 class="info-card-title"><?= h($cultivo->nome) ?></h4>
                            <div class="info-card-actions">
                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'ProdutosCultivados', 'action' => 'edit', $cultivo->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Produto', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-trash"></i>',
                                    '#',
                                    [
                                        'class' => 'btn-action btn-delete js-delete-produtocultivado-link',
                                        'title' => 'Excluir Produto',
                                        'escape' => false,
                                        'data-entity-id' => $cultivo->id,
                                        'data-entity-name' => h($cultivo->nome),
                                        'data-controller' => 'ProdutosCultivados',
                                        'data-url' => $this->Url->build(['controller' => 'ProdutosCultivados', 'action' => 'delete', $cultivo->id, '?' => ['id_produtor' => $produtor->id]])
                                    ]
                                ) ?>
                            </div>
                        </div>
                        <!-- form oculto para exclusão -->
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'ProdutosCultivados', 'action' => 'delete', $cultivo->id, '?' => ['id_produtor' => $produtor->id]],
                            'id' => 'delete-form-produtocultivado-' . $cultivo->id,
                            'style' => 'display:none;'
                        ]) ?>
                        <?= $this->Form->end() ?>
                        <p><strong>Produção Anual:</strong>
                            <span><?= number_format((float) $cultivo->producao_anual, 2, ',', '.') . ' ' . h($cultivo->unidade) ?></span>
                        </p>
                        <p>
                            <strong>Preço/Unid:</strong>
                            <span>R$
                                <?= number_format((float) $cultivo->preco, 2, ',', '.') ?>
                            </span>
                        </p>
                        <p>
                            <strong>Período da colheita:</strong>
                            <span>
                                <?= $cultivo->periodo_colheita ?>
                            </span>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Criações de Animais -->
    <?php if (!empty($produtor->criacoes_animais)): ?>
        <div class="details-card">
            <h3 class="card-title">Criações de Animais</h3>
            <div class="card-grid">
                <?php foreach ($produtor->criacoes_animais as $criacao): ?>
                    <div class="info-card">
                        <div class="card-header-actions">
                            <h4 class="info-card-title"><?= h($criacao->especie) ?></h4>
                            <div class="info-card-actions">
                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'CriacoesAnimais', 'action' => 'edit', $criacao->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Criação', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-trash"></i>',
                                    '#',
                                    [
                                        'class' => 'btn-action btn-delete js-delete-criacaoanimal-link',
                                        'title' => 'Excluir Criação',
                                        'escape' => false,
                                        'data-entity-id' => $criacao->id,
                                        'data-entity-name' => h($criacao->especie),
                                        'data-controller' => 'CriacoesAnimais',
                                        'data-url' => $this->Url->build(['controller' => 'CriacoesAnimais', 'action' => 'delete', $criacao->id, '?' => ['id_produtor' => $produtor->id]])
                                    ]
                                ) ?>
                            </div>
                        </div>
                        <!-- form oculto para exclusão -->
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'CriacoesAnimais', 'action' => 'delete', $criacao->id],
                            'id' => 'delete-form-criacaoanimal-' . $criacao->id,
                            'style' => 'display:none;'
                        ]) ?>
                        <?= $this->Form->hidden('id_produtor', ['value' => $produtor->id]) ?>
                        <?= $this->Form->hidden('redirect_to', ['value' => 'produtor_view']) ?>
                        <?= $this->Form->end() ?>

                        <p><strong>Raça:</strong> <span><?= h($criacao->raca) ?: 'N/A' ?></span></p>
                        <p><strong>Finalidade:</strong> <span><?= h($criacao->finalidade) ?: 'N/A' ?></span></p>
                        <p><strong>Quantidade:</strong>
                            <span><?= h($criacao->quantidade) . ' ' . h($criacao->unidade) ?></span>
                        </p>
                        <!-- Dados de Manejo Sanitário (diretamente na Criação) -->
                        <?php if ($criacao->realiza_exame !== null || $criacao->vacinado !== null || !empty($criacao->tipo_exame) || !empty($criacao->tipo_vacinacao)): ?>
                            <div class="nested-details">
                                <h5 class="nested-title">Manejo Sanitário</h5>
                                <p><strong>Realiza Exame:</strong>
                                    <span><?= $criacao->realiza_exame ? 'Sim' : 'Não' ?></span>
                                </p>
                                <p><strong>Vacinado:</strong>
                                    <span><?= $criacao->vacinado ? 'Sim' : 'Não' ?></span>
                                </p>
                                <?php if (!empty($criacao->tipo_exame)): ?>
                                    <p><strong>Tipo de Exame:</strong> <span><?= h($criacao->tipo_exame) ?></span></p>
                                <?php endif; ?>
                                <?php if (!empty($criacao->tipo_vacinacao)): ?>
                                    <p><strong>Tipo de Vacinação:</strong> <span><?= h($criacao->tipo_vacinacao) ?></span></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Insumos Utilizados -->
    <?php if (!empty($produtor->insumos_utilizados)): ?>
        <div class="details-card">
            <h3 class="card-title">Insumos Utilizados</h3>
            <div class="card-grid">
                <?php foreach ($produtor->insumos_utilizados as $insumo): ?>
                    <div class="info-card">
                        <div class="card-header-actions">
                            <h4 class="info-card-title"><?= h($insumo->nome) ?></h4>
                            <div class="info-card-actions">
                                <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'InsumosUtilizados', 'action' => 'edit', $insumo->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Criação', 'escape' => false]) ?>
                                <?= $this->Html->link(
                                    '<i class="fas fa-trash"></i>',
                                    '#',
                                    [
                                        'class' => 'btn-action btn-delete js-delete-insumo-link',
                                        'title' => 'Excluir Insumo',
                                        'escape' => false,
                                        'data-entity-id' => $insumo->id,
                                        'data-entity-name' => h($insumo->nome),
                                        'data-controller' => 'InsumosUtilizados',
                                        'data-url' => $this->Url->build(['controller' => 'InsumosUtilizados', 'action' => 'delete', $insumo->id, '?' => ['id_produtor' => $produtor->id]])
                                    ]
                                ) ?>
                            </div>
                        </div>
                        <!-- form oculto para exclusão -->
                        <?= $this->Form->create(null, [
                            'url' => ['controller' => 'InsumosUtilizados', 'action' => 'delete', $insumo->id, '?' => ['id_produtor' => $produtor->id]],
                            'id' => 'delete-form-insumo-' . $insumo->id,
                            'style' => 'display:none;'
                        ]) ?>
                        <?= $this->Form->end() ?>
                        <ul class="details-list-actions">
                            <?php foreach ($produtor->insumos_utilizados as $insumo): ?>
                                <ul class="details-list">
                                    <?php foreach ($produtor->insumos_utilizados as $insumo): ?>
                                        <p><strong>Preço:</strong>
                                            <span><?= h($insumo->preco) ? 'R$' . h($insumo->preco) : 'N/A' ?></span>
                                        </p>
                                        <p><strong>Local de compra:</strong> <span><?= h($insumo->local_compra) ?: 'N/A' ?></span></p>
                                        <p><strong>Quantidade:</strong>
                                            <span><?= h($insumo->quantidade) . ' ' . h($insumo->unidade) ?></span>
                                        </p>

                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Família e Mão de Obra -->
    <?php if ($produtor->familia_mao_de_obra): ?>
        <div class="details-card">
            <div class="card-header-actions">
                <h3 class="card-title">Família e Mão de Obra</h3>
                <div class="info-card-actions">
                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'FamiliaMaoDeObra', 'action' => 'edit', $produtor->familia_mao_de_obra->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Dados', 'escape' => false]) ?>
                </div>
            </div>
            <div class="details-grid">
                <div><strong>Dependentes:</strong>
                    <span><?= h($produtor->familia_mao_de_obra->total_dependentes) ?: 0 ?></span>
                </div>
                <div><strong>Na produção:</strong>
                    <span><?= h($produtor->familia_mao_de_obra->qtd_familia_producao) ?: 0 ?></span>
                </div>
                <div><strong>Empregados:</strong>
                    <span><?= h($produtor->familia_mao_de_obra->qtd_empregados) ?: 0 ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Perfil Gerencial -->
    <?php if ($produtor->perfil_gerencial): ?>
        <div class="details-card">
            <div class="card-header-actions">
                <h3 class="card-title">Perfil Gerencial</h3>
                <div class="info-card-actions">
                    <?= $this->Html->link('<i class="fas fa-edit"></i>', ['controller' => 'PerfilGerencial', 'action' => 'edit', $produtor->perfil_gerencial->id, '?' => ['id_produtor' => $produtor->id]], ['class' => 'btn-action btn-edit', 'title' => 'Editar Perfil', 'escape' => false]) ?>
                </div>
            </div>
            <!-- Parte 1: Booleans -->
            <div class="details-grid">
                <div><strong>Emite Nota:</strong>
                    <span><?= $produtor->perfil_gerencial->possui_nota ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Faz DECLAN:</strong>
                    <span><?= $produtor->perfil_gerencial->faz_declan ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Inscrito no INSS:</strong>
                    <span><?= $produtor->perfil_gerencial->inscrito_inss ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Faria Cursos:</strong>
                    <span><?= $produtor->perfil_gerencial->faria_curso ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Conhece Crédito:</strong>
                    <span><?= $produtor->perfil_gerencial->conhece_credito ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Utilizou Crédito:</strong>
                    <span><?= $produtor->perfil_gerencial->utilizou_credito ? 'Sim' : 'Não' ?></span>
                </div>
                <div><strong>Conhece Programas:</strong>
                    <span><?= $produtor->perfil_gerencial->conhece_programas ? 'Sim' : 'Não' ?></span>
                </div>
            </div>

            <!-- Parte 2: Textos descritivos -->
            <?php if ($produtor->perfil_gerencial->curso_interesse): ?>
                <div class="details-text-block"><strong>Cursos de Interesse:</strong>
                    <p><?= h($produtor->perfil_gerencial->curso_interesse) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($produtor->perfil_gerencial->programas): ?>
                <div class="details-text-block"><strong>Programas Governamentais:</strong>
                    <p><?= h($produtor->perfil_gerencial->programas) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($produtor->perfil_gerencial->dificuldade_producao): ?>
                <div class="details-text-block"><strong>Dificuldades de Produção:</strong>
                    <p><?= h($produtor->perfil_gerencial->dificuldade_producao) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($produtor->perfil_gerencial->dificuldade_infraestrutura): ?>
                <div class="details-text-block"><strong>Dificuldades de Infraestrutura:</strong>
                    <p><?= h($produtor->perfil_gerencial->dificuldade_infraestrutura) ?></p>
                </div>
            <?php endif; ?>
            <?php if ($produtor->perfil_gerencial->dificuldade_comercializacao): ?>
                <div class="details-text-block"><strong>Dificuldades de Comercialização:</strong>
                    <p><?= h($produtor->perfil_gerencial->dificuldade_comercializacao) ?></p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Botão de Voltar -->
    <div class="form-actions-details">
        <?= $this->Html->link('<i class="fas fa-arrow-left"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
    </div>
</div>
<?php $this->append(name: 'script'); ?>
<?= $this->Html->script('produtores-view'); ?>
<?php $this->end(); ?>