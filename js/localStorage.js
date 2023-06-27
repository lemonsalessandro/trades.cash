document.addEventListener('DOMContentLoaded', function() {
    // Verifica se há um valor armazenado para o modo escuro
    let darkMode = localStorage.getItem('darkMode') === 'true';
  
    // Função para alternar o modo escuro
    function toggleDarkMode() {
      darkMode = !darkMode;
      localStorage.setItem('darkMode', darkMode); // Atualiza o valor no Local Storage
      applyDarkMode();
    }
  
    // Função para aplicar as alterações de estilo
    function applyDarkMode() {
      if (darkMode) {
        document.body.classList.add('dark-mode');
      } else {
        document.body.classList.remove('dark-mode');
      }
    }
  
    applyDarkMode();
  
    // Configura o evento de clique no botão para alternar o modo escuro
    const darkModeToggle = document.getElementById('darkModeToggle');
    darkModeToggle.addEventListener('click', toggleDarkMode);
  });
  