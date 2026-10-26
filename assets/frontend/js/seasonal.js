document.addEventListener("DOMContentLoaded", function() {
    const body = document.body;
    let particleChar = [];
    let count = 0;

    // Detectar temporada activa según la clase del body
    if (body.classList.contains('season-christmas')) {
        particleChar = ['❄️', '🎄', '🎅', '⛄'];
        count = 30; 
    } else if (body.classList.contains('season-halloween')) {
        particleChars = ['🦇', '🎃', '👻'];
        count = 20; 

        const cornerWebs = [
            { pos: 'top-left', img: 't1.png' },    
            { pos: 'top-right', img: 't2.png' },
            { pos: 'top-center', img: 't2.png' } 
        ];

        cornerWebs.forEach(corner => {
            let cornerDiv = document.createElement('div');
            cornerDiv.className = `corner-decoration corner-${corner.pos}`;
            
            let img = document.createElement('img');
            img.src = base_url + 'uploads/seasonal/halloween/' + corner.img;
            cornerDiv.appendChild(img);
            
            document.body.appendChild(cornerDiv);
        });

        // --- FUNCIÓN DE LA BRUJA VOLADORA ---
        function launchWitch() {
            let witch = document.createElement('img');
            witch.src = base_url + 'uploads/seasonal/halloween/witch.png';
            witch.className = 'flying-witch';

            let direction = Math.floor(Math.random() * 2);
            
            let randomTop = Math.random() * 45 + 10; 
            
            let duration = Math.random() * 4 + 6; 

            witch.style.top = randomTop + 'vh';

            if (direction === 0) {
                witch.style.animation = `flyLeftToRight ${duration}s linear forwards`;
            } else {
                witch.style.animation = `flyRightToLeft ${duration}s linear forwards`;
            }

            document.body.appendChild(witch);

            setTimeout(() => {
                witch.remove();
            }, duration * 1000);
        }

        setTimeout(launchWitch, 5000);

        setInterval(launchWitch, 30000);
    }

    if (particleChars.length > 0) {
        for (let i = 0; i < count; i++) {
            let particle = document.createElement('div');
            particle.className = 'seasonal-particle';
            
            let randomChar = particleChars[Math.floor(Math.random() * particleChars.length)];
            particle.innerHTML = randomChar;
            
            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.animationDuration = (Math.random() * 6 + 4) + 's'; 
            particle.style.animationDelay = (Math.random() * 5) + 's';
            particle.style.fontSize = (Math.random() * 14 + 14) + 'px'; 
            
            document.body.appendChild(particle);
        }
    }
});