<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PerfilGerencial $perfil
 * @var string[]|\Cake\Collection\CollectionInterface $produtores
 * @var string $formTitle
 * @var int|null $id
 */
?>

<div class="header">
    <h1><?= h($formTitle) ?></h1>
    <p>Preencha os dados abaixo para cadastrar um novo perfil.</p>
</div>

<div class="perfil-gerencial-form">
    <?= $this->Form->create($perfil, ['id' => 'perfilGerencialForm', 'url' => ['action' => 'add', $id ?? null]]) ?>
    <?= $this->Form->hidden('redirect_to', ['value' => $produtorId ? 'produtor_view' : 'perfil_gerencial_index']) ?>

    <?php if ($perfil->getErrors()): ?>
        <div class="alert alert-danger">
            <!-- Mensagens de erro, se houver -->
        </div>
    <?php endif; ?>

    <div class="form-grid">
        <!-- Card: Informações Gerais (Ocupa a linha inteira) -->
        <div class="form-card full-width">
            <h3>Produtor Associado <span class="required">*</span></h3>
           <?= $this->Form->control('id_produtor', [
                'label' => '',
                'escape' => false,
                'options' => [], // As opções são carregadas via AJAX
                'empty' => 'Selecione um produtor...',
                'class' => 'form-control select2-producer',
                'id' => 'produtor-select',
                'required' => true,
                'data-initial-value' => $perfil->id_produtor ?? '',
                'data-initial-text-nome' => $perfil->has('produtor') ? $perfil->produtor->nome : '',
                'data-initial-text-cpf' => $perfil->has('produtor') ? $perfil->produtor->cpf : '',
            ]) ?>
            <div class="form-group">
                <div class="form-row">
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="search_by_name">Nome</label>
                        <input class="form-check-input" type="radio" name="search_type" id="search_by_name" value="nome"
                            checked>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="search_by_cpf">CPF</label>
                        <input class="form-check-input" type="radio" name="search_type" id="search_by_cpf" value="cpf">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Documentação -->
        <div class="form-card">
            <h3>Documentação</h3>
            <div class="checkbox-list">
                <?= $this->Form->control('possui_nota', ['type' => 'checkbox', 'label' => 'Possui nota de produtor?', 'templateVars' => ['container_class' => 'checkbox-control']]) ?>
                <?= $this->Form->control('faz_declan', ['type' => 'checkbox', 'label' => 'Faz DECLAN?', 'templateVars' => ['container_class' => 'checkbox-control']]) ?>
                <?= $this->Form->control('inscrito_inss', ['type' => 'checkbox', 'label' => 'Inscrito no INSS?', 'templateVars' => ['container_class' => 'checkbox-control']]) ?>
            </div>
        </div>

        

        <!-- Card: Crédito -->
        <div class="form-card">
            <h3>Crédito</h3>
            <div class="checkbox-list">
                <?= $this->Form->control('conhece_credito', ['type' => 'checkbox', 'label' => 'Conhece linhas de crédito rural?', 'templateVars' => ['container_class' => 'checkbox-control']]) ?>
                <?= $this->Form->control('utilizou_credito', ['type' => 'checkbox', 'label' => 'Já utilizou crédito rural?', 'templateVars' => ['container_class' => 'checkbox-control']]) ?>
            </div>
        </div>

        <!-- Card: Comercialização (Ocupa 2 colunas) -->
        <div class="form-card">
            <h3>Comercialização</h3>
            <div class="sub-section">
                <h4>Canais de Venda</h4>
                <div class="checkbox-list vertical">
                    <?= $this->Form->control('varejo_petropolis', ['type' => 'checkbox', 'label' => 'Varejo em Petrópolis', 'templateVars' => ['container_class' => 'checkbox-control-vertical']]) ?>
                    <?= $this->Form->control('varejo_cidade', ['type' => 'checkbox', 'label' => 'Varejo em outras cidades', 'templateVars' => ['container_class' => 'checkbox-control-vertical']]) ?>
                    <?= $this->Form->control('atacado_petropolis', ['type' => 'checkbox', 'label' => 'Atacado em Petrópolis', 'templateVars' => ['container_class' => 'checkbox-control-vertical']]) ?>
                    <?= $this->Form->control('atacado_cidades', ['type' => 'checkbox', 'label' => 'Atacado em outras cidades', 'templateVars' => ['container_class' => 'checkbox-control-vertical']]) ?>
                    <?= $this->Form->control('comercializar_produtos', ['type' => 'checkbox', 'label' => 'Comercializa produtos processados?', 'templateVars' => ['container_class' => 'checkbox-control-vertical']]) ?>
                </div>
            </div>
            <div class="sub-section">
                <?= $this->Form->control('outras_receitas', [
                    'type' => 'textarea', 'rows' => 3, 'class' => 'form-control',
                    'label' => 'Outras fontes de receita na propriedade?',
                    'placeholder' => 'Ex: Turismo rural, aluguel...'
                ]) ?>
            </div>
        </div>

        <!-- Card: Capacitação -->
        <div class="form-card">
            <h3>Capacitação</h3>
            <div class="checkbox-list">
                <?= $this->Form->control('faria_curso', [
                    'type' => 'checkbox',
                    'label' => 'Teria interesse em fazer cursos?',
                    'id' => 'faria-curso-checkbox',
                    'templateVars' => ['container_class' => 'checkbox-control']
                ]) ?>
            </div>
            <div id="cursos-list-container" style="display:none;">
                <label>Quais cursos teria interesse?</label>
                <div class="checkbox-list vertical">
                <?php
                    $cursosOptions = [
                        'Gestão da Propriedade Rural' => 'Gestão da Propriedade Rural',
                        'Agroecologia' => 'Agroecologia',
                        'Cultivo Orgânico' => 'Cultivo Orgânico',
                        'Manejo de Pragas e Doenças' => 'Manejo de Pragas e Doenças',
                        'Irrigação e Manejo da Água' => 'Irrigação e Manejo da Água',
                        'Pecuária de Leite' => 'Pecuária de Leite',
                        'Avicultura' => 'Avicultura',
                        'Piscicultura' => 'Piscicultura',
                        'Beneficiamento de Alimentos' => 'Beneficiamento de Alimentos',
                        'Boas Práticas de Fabricação' => 'Boas Práticas de Fabricação (BPF)',
                        'Comercialização e Marketing' => 'Comercialização e Marketing',
                    ];
                    $selectedCursos = !empty($perfil->curso_interesse) ? explode(', ', $perfil->curso_interesse) : [];

                    echo $this->Form->control('cursos_list', [
                        'type' => 'select',
                        'multiple' => 'checkbox',
                        'options' => $cursosOptions,
                        'label' => false,
                        'value' => $selectedCursos,
                        'templateVars' => ['container_class' => 'cursos-checkboxes']
                    ]);
                ?>
                </div>
                <?= $this->Form->control('curso_interesse', ['type' => 'hidden', 'id' => 'curso-interesse-hidden-input']) ?>
            </div>
        </div>

        <!-- Card: Programas -->
        <div class="form-card">
            <h3>Programas</h3>
            <div class="checkbox-list">
                <?= $this->Form->control('conhece_programas', [                 
             'type' => 'checkbox',                                       
             'id' => 'conhece-programas-checkbox',                       
             'label' => 'Conhece programas de apoio?',                   
             'templateVars' => ['container_class' => 'checkbox-control'] 
         ]) ?>                                                           
     </div>                                                              
     <div id="programas-list-container" style="display:none;">           
         <label>Quais programas?</label>                                 
         <div class="checkbox-list vertical">                            
         <?php                                                           
             $programasOptions = [                                       
                 'PRONAF' => 'PRONAF',                                   
                 'PAA' => 'PAA (Aquisição de Alimentos)',                
                 'PNAE' => 'PNAE (Alimentação Escolar)',                 
                 'Garantia-Safra' => 'Garantia-Safra',                   
                 'Proagro' => 'Proagro',                                 
                 'Crédito Fundiário' => 'Crédito Fundiário',             
                 'ATER' => 'ATER (Assistência Técnica)',                 
             ];                                                          
             $selectedProgramas = !empty($perfil->programas) ? explode(', ', $perfil->programas) : [];
                                                                         
             echo $this->Form->control('programas_list', [               
                 'type' => 'select',                                     
                 'multiple' => 'checkbox',                               
                 'options' => $programasOptions,                         
                 'label' => false,                                       
                 'value' => $selectedProgramas,                          
                 'templateVars' => ['container_class' => 'programas-checkboxes']                         
             ]);                                                         
         ?>                                                              
         </div>                                                          
         <?= $this->Form->control('programas', ['type' => 'hidden', 'id' => 'programas-hidden-input']) ?>
     </div>  
        </div>

        <!-- Card: Dificuldades na Produção -->
        <div class="form-card">
            <?= $this->Form->control('dificuldade_producao', ['type' => 'textarea', 'rows' => 4, 'label' => 'Dificuldades na Produção', 'placeholder' => 'Descreva as principais dificuldades...']) ?>
        <!-- Card: Dificuldades de Infraestrutura -->
            <?= $this->Form->control('dificuldade_infraestrutura', ['type' => 'textarea', 'rows' => 4, 'label' => 'Dificuldades de Infraestrutura', 'placeholder' => 'Descreva as principais dificuldades...']) ?>
        <!-- Card: Dificuldades na Comercialização -->
            <?= $this->Form->control('dificuldade_comercializacao', ['type' => 'textarea', 'rows' => 4, 'label' => 'Dificuldades na Comercialização', 'placeholder' => 'Descreva as principais dificuldades...']) ?>
        </div>

    </div> <!-- fim do .form-grid -->

    <div class="form-actions">
        <?= $this->Form->button('Salvar', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
        <?= $this->Html->link($id == null ? 'Voltar' : 'Cancelar', $produtorId ? ['controller' => 'Produtores', 'action' => 'view', $produtorId] : ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<?php $this->append('script'); ?>
<?= $this->Html->script(url: 'app-masks'); ?>
<?= $this->Html->script(url: 'producer-select'); ?>
<?= $this->Html->script(url: 'form-not'); ?>
<?= $this->Html->script(url: 'perfil-gerencial-form'); ?>
<?php $this->end(); ?>
