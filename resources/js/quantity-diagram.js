const { Chart } = require("chart.js/dist");

async function getData() {
    fetch("/charts/quantity-diagram", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            url: "/charts/quantity-diagram",
            "X-CSRF-Token": document.querySelector("input[name=_token]").value,
        },
    });
}

const ctx = document.getElementById("quantityDiagramChart");

new Chart(ctx, getData());
