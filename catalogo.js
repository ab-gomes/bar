document.addEventListener('DOMContentLoaded', () => {
    const filterTipoSelect = document.getElementById('filter-tipo');
    const filterTeorSelect = document.getElementById('filter-teor');
    const filterPromocaoSelect = document.getElementById('filter-promocao');
    const filterOrigemSelect = document.getElementById('filter-origem');
    const filterPrecoRange = document.getElementById('filter-preco');
    const precoMaxValueSpan = document.getElementById('preco-max-value');
    const filterMarcaInput = document.getElementById('filter-marca');
    const searchInput = document.getElementById('search-input'); // New search input
    const searchButton = document.getElementById('search-button'); // New search button

    const bebidasLista = document.getElementById('bebidas-lista');
    const bebidasItems = bebidasLista.querySelectorAll('.bebidas-item');
    const categoryFilterItems = document.querySelectorAll('.filter-category-item'); // Clicable category sections

    // --- Event Listeners for Detailed Filters ---
    filterPrecoRange.addEventListener('input', () => {
        precoMaxValueSpan.textContent = `R$ ${filterPrecoRange.value}`;
        applyFilters();
    });

    filterTipoSelect.addEventListener('change', applyFilters);
    filterTeorSelect.addEventListener('change', applyFilters);
    filterPromocaoSelect.addEventListener('change', applyFilters);
    filterOrigemSelect.addEventListener('change', applyFilters);
    filterMarcaInput.addEventListener('input', applyFilters);

    // --- Event Listeners for Search Bar ---
    searchInput.addEventListener('input', applyFilters); // Live search
    searchButton.addEventListener('click', applyFilters); // Button click (can be redundant with 'input')

    // --- Event Listeners for Category Filter Sections ---
    categoryFilterItems.forEach(item => {
        item.addEventListener('click', () => {
            const filterType = item.dataset.filterType; // 'tipo' or 'promocao'
            const filterValue = item.dataset.filterValue; // e.g., 'cerveja' or 'sim'

            // Reset all filters first, then apply the selected category filter
            resetDetailedFilters();

            if (filterType === 'tipo') {
                filterTipoSelect.value = filterValue;
            } else if (filterType === 'promocao') {
                filterPromocaoSelect.value = filterValue;
            }
            
            applyFilters(); // Apply the new filter
            
            // Scroll to the main catalog section
            const catalogSection = document.getElementById('catalogo-completo');
            if (catalogSection) {
                catalogSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // --- Filter Application Logic ---
    function applyFilters() {
        const selectedTipo = filterTipoSelect.value;
        const selectedTeor = filterTeorSelect.value;
        const selectedPromocao = filterPromocaoSelect.value;
        const selectedOrigem = filterOrigemSelect.value;
        const maxPrice = parseFloat(filterPrecoRange.value);
        const searchMarca = filterMarcaInput.value.toLowerCase().trim();
        const searchTerm = searchInput.value.toLowerCase().trim(); // Get search term

        bebidasItems.forEach(item => {
            const itemTipo = item.dataset.tipo;
            const itemTeor = item.dataset.teorCategoria;
            const itemPromocao = item.dataset.promocao;
            const itemOrigem = item.dataset.origem;
            const itemPrice = parseFloat(item.dataset.preco);
            const itemMarca = item.dataset.marca;
            const itemNome = item.dataset.nome; // Get item name for search

            let matches = true;

            // Filter by Type
            if (selectedTipo !== 'todos' && itemTipo !== selectedTipo) {
                matches = false;
            }

            // Filter by Teor Alcoólico
            if (matches && selectedTeor !== 'todos' && itemTeor !== selectedTeor) {
                matches = false;
            }

            // Filter by Promoção
            if (matches && selectedPromocao !== 'todos' && itemPromocao !== selectedPromocao) {
                matches = false;
            }

            // Filter by Origem
            if (matches && selectedOrigem !== 'todos' && itemOrigem !== selectedOrigem) {
                matches = false;
            }

            // Filter by Preço Máximo
            if (matches && itemPrice > maxPrice) {
                matches = false;
            }

            // Filter by Marca (text search)
            if (matches && searchMarca !== '' && !itemMarca.includes(searchMarca)) {
                matches = false;
            }

            // Filter by Name/Brand Search (from banner search bar)
            if (matches && searchTerm !== '' && !(itemNome.includes(searchTerm) || itemMarca.includes(searchTerm))) {
                matches = false;
            }

            if (matches) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    // --- Function to reset detailed filters ---
    function resetDetailedFilters() {
        filterTipoSelect.value = 'todos';
        filterTeorSelect.value = 'todos';
        filterPromocaoSelect.value = 'todos';
        filterOrigemSelect.value = 'todos';
        filterPrecoRange.value = filterPrecoRange.max; // Reset price slider to max
        precoMaxValueSpan.textContent = `R$ ${filterPrecoRange.max}`;
        filterMarcaInput.value = '';
        searchInput.value = ''; // Also clear the banner search
    }

    // Initial filter application on page load
    applyFilters();
});

// Removed scrollToReservas as the new category filter clicks handle scrolling.
// If you still need a general "scroll to catalog" button elsewhere, you can re-add it.