// initialize icons
lucide.createIcons();

// insert year
document.getElementById("year").textContent = new Date().getFullYear();

// cart data (seeded from DOM values)
const items = [
  {
    id: 1,
    name: "Adidas Ozweego",
    price: 699,
    qty: 1,
    img: "https://cdn.runrepeat.com/storage/gallery/product_primary/32545/adidas-ozweego-21158485-720.jpg",
  },
  {
    id: 2,
    name: "New Balance 9060",
    price: 1299,
    qty: 1,
    img: "https://cdn.runrepeat.com/storage/gallery/product_primary/38821/new-balance-9060-21208162-720.jpg",
  },
  {
    id: 3,
    name: "Nike Zoom Vomero 5",
    price: 1234,
    qty: 1,
    img: "https://cdn.runrepeat.com/storage/gallery/product_primary/39411/nike-zoom-vomero-5-lab-test-and-review-3-21506315-720.jpg",
  },
];

const format = (v) => "R$ " + v.toLocaleString("pt-BR");

function recalc() {
  let subtotal = 0;
  items.forEach((it) => (subtotal += it.price * it.qty));
  const shipping = subtotal > 3000 ? 0 : 49;
  const total = subtotal + shipping;
  document.getElementById("subtotal").textContent = format(subtotal);
  document.getElementById("shipping").textContent = format(shipping);
  document.getElementById("total").textContent = format(total);
  document.getElementById("mini-sub").textContent = format(subtotal);
  document.getElementById("mini-shipping").textContent = format(shipping);
  document.getElementById("mini-total").textContent = format(total);
}

recalc();

// quantity and remove handlers
function updateFromInputs() {
  document.querySelectorAll(".qty-input").forEach((inp) => {
    const id = Number(inp.dataset.id);
    const it = items.find((i) => i.id === id);
    if (it) {
      it.qty = Math.max(1, Number(inp.value));
    }
  });
  recalc();
}

document.querySelectorAll(".qty-increase").forEach((btn) =>
  btn.addEventListener("click", (e) => {
    const id = Number(e.currentTarget.dataset.id);
    const it = items.find((i) => i.id === id);
    if (it) {
      it.qty += 1;
      document.querySelector('.qty-input[data-id="' + id + '"]').value = it.qty;
      recalc();
    }
  })
);
document.querySelectorAll(".qty-decrease").forEach((btn) =>
  btn.addEventListener("click", (e) => {
    const id = Number(e.currentTarget.dataset.id);
    const it = items.find((i) => i.id === id);
    if (it && it.qty > 1) {
      it.qty -= 1;
      document.querySelector('.qty-input[data-id="' + id + '"]').value = it.qty;
      recalc();
    }
  })
);
document.querySelectorAll(".qty-input").forEach((inp) =>
  inp.addEventListener("change", () => {
    updateFromInputs();
  })
);

document.querySelectorAll(".remove-btn").forEach((btn) =>
  btn.addEventListener("click", (e) => {
    const id = Number(e.currentTarget.dataset.id);
    // remove block from DOM elegantly
    const el = e.currentTarget.closest(".card");
    gsap.to(el, {
      duration: 0.3,
      opacity: 0,
      height: 0,
      margin: 0,
      onComplete: () => el.remove(),
    });
    const idx = items.findIndex((i) => i.id === id);
    if (idx > -1) items.splice(idx, 1);
    setTimeout(recalc, 350);
    // update cart count
    const cnt = items.reduce((s, i) => s + i.qty, 0);
    document.getElementById("cart-count").textContent = cnt;
  })
);

// proceed to checkout
document.getElementById("to-checkout").addEventListener("click", () => {
  // populate mini-list
  const mini = document.getElementById("mini-list");
  mini.innerHTML = "";
  items.forEach((i) => {
    const div = document.createElement("div");
    div.className = "flex items-center gap-3";
    div.innerHTML = `<img src="${
      i.img
    }" class="w-12 h-10 object-cover rounded"> <div class="flex-1 text-sm">${
      i.name
    } <div class='text-white/60 text-xs'>Qtd: ${
      i.qty
    }</div></div> <div class='text-sm font-semibold'>${format(
      i.price * i.qty
    )}</div>`;
    mini.appendChild(div);
  });
  // switch views
  gsap.to("#cart-section", {
    duration: 0.35,
    opacity: 0,
    pointerEvents: "none",
    onComplete: () => {
      document.getElementById("cart-section").classList.add("hidden");
      document.getElementById("checkout-section").classList.remove("hidden");
      gsap.fromTo(
        "#checkout-section",
        { opacity: 0, y: 20 },
        { opacity: 1, y: 0 }
      );
    },
  });
  // update progress steps
  document.querySelector("#step-cart div")?.classList?.add("text-white/50");
  document
    .getElementById("step-cart")
    .querySelector("div")
    ?.classList?.remove("bg-roxa");
  document
    .getElementById("step-address")
    .querySelector("div")
    .classList.remove("bg-white/6");
  document
    .getElementById("step-address")
    .querySelector("div")
    .classList.add("bg-roxa");
});

// confirm order
document.getElementById("confirm-order").addEventListener("click", () => {
  // show modal
  const modal = document.getElementById("modal");
  modal.classList.remove("hidden");
  modal.classList.add("flex");
  gsap.fromTo(
    "#modal > div",
    { scale: 0.96, opacity: 0 },
    { scale: 1, opacity: 1, duration: 0.35 }
  );
});

document.getElementById("close-modal").addEventListener("click", () => {
  const modal = document.getElementById("modal");
  gsap.to("#modal > div", {
    scale: 0.96,
    opacity: 0,
    duration: 0.2,
    onComplete: () => {
      modal.classList.add("hidden");
      modal.classList.remove("flex");
    },
  });
});

// small entrance animation
window.addEventListener("load", () => {
  gsap.from("main h1, main h2", {
    y: 8,
    opacity: 0,
    stagger: 0.06,
    duration: 0.6,
  });
});
