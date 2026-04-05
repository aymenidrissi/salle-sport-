import Chart from 'chart.js/auto';

const el = document.getElementById('admin-statistics-config');
if (!el) {
    throw new Error('admin-statistics-config manquant');
}

const config = JSON.parse(el.textContent || '{}');
const engagement = config.engagement || { labels: [], members: [], videos: [] };
const programs = config.programs || { labels: [], values: [], colors: [] };
const revenue = config.revenue || { labels: [], amounts: [] };
const ordersByStatus = config.ordersByStatus || { labels: [], values: [], colors: [] };
const topPrograms = config.topPrograms || { labels: [], values: [] };

const animationCommon = {
    duration: 1200,
    easing: 'easeOutQuart',
};

const brand =
    getComputedStyle(document.documentElement).getPropertyValue('--color-brand').trim() || '#e53e3e';

// —— Engagement (ligne)
const lineCanvas = document.getElementById('chart-stat-engagement');
if (lineCanvas) {
    const ctx = lineCanvas.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: engagement.labels,
                datasets: [
                    {
                        label: 'Nouveaux membres',
                        data: engagement.members,
                        borderColor: brand,
                        backgroundColor: 'rgba(229, 62, 62, 0.12)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 3,
                        pointHoverRadius: 5,
                    },
                    {
                        label: 'Vidéos ajoutées',
                        data: engagement.videos,
                        borderColor: '#3b82f6',
                        backgroundColor: 'transparent',
                        fill: false,
                        tension: 0.35,
                        borderWidth: 2,
                        borderDash: [6, 5],
                        pointRadius: 2,
                        pointHoverRadius: 4,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationCommon,
                interaction: { intersect: false, mode: 'index' },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { boxWidth: 10, padding: 16, font: { size: 11 } },
                    },
                    tooltip: {
                        animation: { duration: 200 },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#a1a1aa' },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { size: 10 }, color: '#a1a1aa' },
                        grid: { color: 'rgba(0,0,0,0.06)' },
                    },
                },
            },
        });
    }
}

// —— Chiffre d’affaires (barres)
const revenueCanvas = document.getElementById('chart-stat-revenue');
if (revenueCanvas && revenue.labels?.length) {
    const ctx = revenueCanvas.getContext('2d');
    if (ctx) {
        const max = Math.max(...revenue.amounts.map((n) => Number(n)), 1);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: revenue.labels,
                datasets: [
                    {
                        label: 'CA (DH)',
                        data: revenue.amounts,
                        backgroundColor: revenue.amounts.map((v) => {
                            const t = Number(v) / max;
                            const a = 0.28 + t * 0.58;
                            return `rgba(229, 62, 62, ${a})`;
                        }),
                        borderColor: brand,
                        borderWidth: 1,
                        borderRadius: 8,
                        borderSkipped: false,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: animationCommon,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (item) => {
                                const v = Number(item.raw);
                                return `${v.toLocaleString('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 2 })} DH`;
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#a1a1aa' },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 10 },
                            color: '#a1a1aa',
                            callback: (v) => `${v}`,
                        },
                        grid: { color: 'rgba(0,0,0,0.06)' },
                    },
                },
            },
        });
    }
}

// —— Commandes par statut
const ordersCanvas = document.getElementById('chart-stat-orders');
if (ordersCanvas && ordersByStatus.labels?.length) {
    const ctx = ordersCanvas.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ordersByStatus.labels,
                datasets: [
                    {
                        data: ordersByStatus.values,
                        backgroundColor: ordersByStatus.colors,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 10,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '58%',
                animation: {
                    ...animationCommon,
                    animateRotate: true,
                    animateScale: true,
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { boxWidth: 10, padding: 12, font: { size: 11 } },
                    },
                },
            },
        });
    }
}

// —— Répartition programmes (donut)
const donutCanvas = document.getElementById('chart-stat-programs');
if (donutCanvas && programs.labels?.length) {
    const ctx = donutCanvas.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: programs.labels,
                datasets: [
                    {
                        data: programs.values,
                        backgroundColor: programs.colors,
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 8,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                animation: {
                    ...animationCommon,
                    animateRotate: true,
                    animateScale: true,
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (item) => {
                                const v = item.raw;
                                const total = programs.values.reduce((a, b) => a + b, 0);
                                const pct = total ? Math.round((v / total) * 100) : 0;
                                return `${item.label}: ${pct}%`;
                            },
                        },
                    },
                },
            },
        });
    }
}

// —— Top programmes (barres horizontales)
const topCanvas = document.getElementById('chart-stat-top-programs');
if (topCanvas && topPrograms.labels?.length) {
    const ctx = topCanvas.getContext('2d');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: topPrograms.labels,
                datasets: [
                    {
                        label: 'Abonnés',
                        data: topPrograms.values,
                        backgroundColor: 'rgba(59, 130, 246, 0.25)',
                        borderColor: '#3b82f6',
                        borderWidth: 1.5,
                        borderRadius: 6,
                    },
                ],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                animation: animationCommon,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0, font: { size: 10 }, color: '#a1a1aa' },
                        grid: { color: 'rgba(0,0,0,0.06)' },
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#52525b' },
                    },
                },
            },
        });
    }
}
