<style>
.hidden {
    display: none;
}

.pagination-container {
    width: calc(100% - 2rem);
    display: flex;
    align-items: center;
    position: absolute;
    bottom: 0;
    padding: 1rem 0;
    justify-content: center;
}

.pagination-number,
.pagination-button {
    font-size: 1.1rem;
    background-color: transparent;
    border: none;
    margin: 0.25rem 0.25rem;
    cursor: pointer;
    height: 2.5rem;
    width: 2.5rem;
    border-radius: .2rem;
}

.pagination-number:hover,
.pagination-button:not(.disabled):hover {
    background: #fff;
}

.pagination-number.active {
    color: #fff;
    background: #0085b6;
}

footer {
    padding: 1em;
    text-align: center;
    background-color: #FFDFB9;
}

footer a {
    color: inherit;
    text-decoration: none;
}

footer .heart {
    color: #DC143C;
}
</style>
<main>
    <h1>Pagination with Vanilla JavaScript</h1>
    <ul id="paginated-list" data-current-page="1" aria-live="polite">
        <?php for($i=0;$i<40;$i++):?>
        <li>
            <p>Pertanyaan <?=$i+1?>: Apa ibu kota Indonesia?</p>
            <label><input type="radio" name="answer<?=$i?>" value="a">a) Jakarta</label>
            <label><input type="radio" name="answer<?=$i?>" value="b">b) Surabaya</label>
            <label><input type="radio" name="answer<?=$i?>" value="c">c) Bandung</label>
        </li>
        <?php endfor;?>
    </ul>

    <nav class="pagination-container">
        <button class="pagination-button" id="prev-button" aria-label="Previous page" title="Previous page">
            &lt;
        </button>

        <div id="pagination-numbers">

        </div>

        <button class="pagination-button" id="next-button" aria-label="Next page" title="Next page">
            &gt;
        </button>
    </nav>
</main>

<footer>
    Pen by <a href="https://www.jemimaabu.com" target="_blank" rel="noopener">Jemima Abu</a> <span
        class="heart">&hearts;</span>
</footer>

<script>
const paginationNumbers = document.getElementById("pagination-numbers");
const paginatedList = document.getElementById("paginated-list");
const listItems = paginatedList.querySelectorAll("li");
const nextButton = document.getElementById("next-button");
const prevButton = document.getElementById("prev-button");

const paginationLimit = 10;
const pageCount = Math.ceil(listItems.length / paginationLimit);
let currentPage = 1;

const disableButton = (button) => {
    button.classList.add("disabled");
    button.setAttribute("disabled", true);
};

const enableButton = (button) => {
    button.classList.remove("disabled");
    button.removeAttribute("disabled");
};

const handlePageButtonsStatus = () => {
    if (currentPage === 1) {
        disableButton(prevButton);
    } else {
        enableButton(prevButton);
    }

    if (pageCount === currentPage) {
        disableButton(nextButton);
    } else {
        enableButton(nextButton);
    }
};

const handleActivePageNumber = () => {
    document.querySelectorAll(".pagination-number").forEach((button) => {
        button.classList.remove("active");
        const pageIndex = Number(button.getAttribute("page-index"));
        if (pageIndex == currentPage) {
            button.classList.add("active");
        }
    });
};

const appendPageNumber = (index) => {
    const pageNumber = document.createElement("button");
    pageNumber.className = "pagination-number";
    pageNumber.innerHTML = index;
    pageNumber.setAttribute("page-index", index);
    pageNumber.setAttribute("aria-label", "Page " + index);

    paginationNumbers.appendChild(pageNumber);
};

const getPaginationNumbers = () => {
    for (let i = 1; i <= pageCount; i++) {
        appendPageNumber(i);
    }
};

const setCurrentPage = (pageNum) => {
    currentPage = pageNum;

    handleActivePageNumber();
    handlePageButtonsStatus();

    const prevRange = (pageNum - 1) * paginationLimit;
    const currRange = pageNum * paginationLimit;

    listItems.forEach((item, index) => {
        item.classList.add("hidden");
        if (index >= prevRange && index < currRange) {
            item.classList.remove("hidden");
        }
    });
};

window.addEventListener("load", () => {
    getPaginationNumbers();
    setCurrentPage(1);

    prevButton.addEventListener("click", () => {
        setCurrentPage(currentPage - 1);
    });

    nextButton.addEventListener("click", () => {
        setCurrentPage(currentPage + 1);
    });

    document.querySelectorAll(".pagination-number").forEach((button) => {
        const pageIndex = Number(button.getAttribute("page-index"));

        if (pageIndex) {
            button.addEventListener("click", () => {
                setCurrentPage(pageIndex);
            });
        }
    });
});
</script>
