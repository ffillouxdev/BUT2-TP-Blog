function updateChar(){
    const char = document.getElementById('caractere')
    const input = document.querySelector('.post-comment textarea')

    if (input) {
        input.addEventListener("input", () => {
            if (input.value.length > 400) {
                input.value = input.value.substring(0, 400); // Limiter à 400 caractères
            }
            char.innerHTML = input.value.length + ' / 400' 
        })
    }
}

updateChar();



function updateComment(){
    document.addEventListener('DOMContentLoaded', () => {
        const voirPlusBtn = document.getElementById('voir-plus');
        const hiddenComments = document.querySelectorAll('.comment.hidden');
        let visibleCount = 0;

        if (voirPlusBtn) {
            console.log("Bouton trouvé, script en cours d'exécution.");
            voirPlusBtn.addEventListener('click', () => {
                console.log("Bouton 'Voir plus' cliqué.");

                let countToShow = 2;
                for (let i = 0; i < countToShow && visibleCount < hiddenComments.length; i++) {
                    console.log("Affichage d'un commentaire supplémentaire.");
                    hiddenComments[visibleCount].classList.remove('hidden');
                    visibleCount++;
                }

                if (visibleCount === hiddenComments.length) {
                    console.log("Tous les commentaires sont affichés, bouton masqué.");
                    voirPlusBtn.style.display = 'none';
                }
            });
        } 
    });
}

updateComment()
