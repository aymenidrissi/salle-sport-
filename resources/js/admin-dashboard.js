import Chart from 'chart.js/auto';

const el = document.getElementById('admin-dashboard-config');
if (!el) {
    throw new Error('admin-dashboard-config manquant');
}

const config = JSON.parse(el.textContent || '{}');
const engagement = config.engagement || { labels: [], members: [], videos: [] };
const programs = config.programs || { labels: [], values: [], colors: [] };

const animationCommon = {
    duration: 1100,
    easing: 'easeOutQuart',
};

const lineCanvas = document.getElementById('chart-engagement');
if (lineCanvas) {
    const ctx = lineCanvas.getContext('2d');
    if (ctx) {
        const brand = getComputedStyle(document.documentElement).getPropertyValue('--color-brand').trim() || '#e53e3e';

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

const donutCanvas = document.getElementById('chart-programs');
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
