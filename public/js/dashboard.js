const sidebar = document.getElementById('sidebar');
const hamburger = document.getElementById('hamburger');

  // Toggle sidebar
  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('minimize');
  });

  // Active menu
  const sidebarLinks = document.querySelectorAll('.menu a');

  sidebarLinks.forEach(link => {
    link.addEventListener('click', () => {
      sidebarLinks.forEach(item => item.classList.remove('active'));
      link.classList.add('active');
    });
  });

  

