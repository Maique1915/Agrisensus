$(document).ready(function() {
    // --- Programas Logic ---
    const conheceProgramasCheckbox = $('#conhece-programas-checkbox');
    const programasListContainer = $('#programas-list-container');

    function toggleProgramasList() {
        if (conheceProgramasCheckbox.is(':checked')) {
            programasListContainer.slideDown();
        } else {
            programasListContainer.slideUp();
        }
    }

    function updateProgramasHiddenInput() {
        const selectedValues = [];
        $('#programas-list-container input[type="checkbox"]:checked').each(function() {
            selectedValues.push($(this).val());
        });
        $('#programas-hidden-input').val(selectedValues.join(', '));
    }

    toggleProgramasList();
    if(conheceProgramasCheckbox.is(':checked')){
        updateProgramasHiddenInput();
    }

    conheceProgramasCheckbox.on('change', function() {
        toggleProgramasList();
        if (!$(this).is(':checked')) {
            $('#programas-list-container input[type="checkbox"]').prop('checked', false);
        }
        updateProgramasHiddenInput();
    });

    $(document).on('change', '#programas-list-container input[type="checkbox"]', function() {
        updateProgramasHiddenInput();
    });

    // --- Cursos/Capacitação Logic ---
    const fariaCursoCheckbox = $('#faria-curso-checkbox');
    const cursosListContainer = $('#cursos-list-container');

    function toggleCursosList() {
        if (fariaCursoCheckbox.is(':checked')) {
            cursosListContainer.slideDown();
        } else {
            cursosListContainer.slideUp();
        }
    }

    function updateCursosHiddenInput() {
        const selectedValues = [];
        $('#cursos-list-container input[type="checkbox"]:checked').each(function() {
            selectedValues.push($(this).val());
        });
        $('#curso-interesse-hidden-input').val(selectedValues.join(', '));
    }

    toggleCursosList();
    if(fariaCursoCheckbox.is(':checked')){
        updateCursosHiddenInput();
    }

    fariaCursoCheckbox.on('change', function() {
        toggleCursosList();
        if (!$(this).is(':checked')) {
            $('#cursos-list-container input[type="checkbox"]').prop('checked', false);
        }
        updateCursosHiddenInput();
    });

    $(document).on('change', '#cursos-list-container input[type="checkbox"]', function() {
        updateCursosHiddenInput();
    });
});