
    var carousels = document.querySelectorAll('.carousel');
    carousels.forEach(carousel => {
        new bootstrap.Carousel(carousel, {
            interval: 3000
        });
    });
});
function addComment() {
    let commentText = document.getElementById("commentInput").value;
    if (commentText.trim() === "") return;
    
    let commentCard = document.createElement("div");
    commentCard.className = "card comment-card";
    commentCard.innerHTML = `
        <div class="card-body">
            <p class="comment-user">John Doe</p>
            <p class="card-text">${commentText}</p>
            <button class="btn btn-success btn-sm" onclick="likeComment(this)">👍 <span>0</span></button>
            <button class="btn btn-danger btn-sm" onclick="dislikeComment(this)">👎 <span>0</span></button>
        </div>
    `;
    document.getElementById("commentSection").prepend(commentCard);
    document.getElementById("commentInput").value = "";
}

function likeComment(button) {
    let countSpan = button.querySelector("span");
    countSpan.textContent = parseInt(countSpan.textContent) + 1;
}

function dislikeComment(button) {
    let countSpan = button.querySelector("span");
    countSpan.textContent = parseInt(countSpan.textContent) + 1;
}

function toggleLike(element) {
    element.classList.toggle("liked");
}
function showAnswer(id) {
    document.getElementById("faq" + id).style.display = "block";
}
function hideAnswer(id) {
    document.getElementById("faq" + id).style.display = "none";
}
