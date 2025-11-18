const colors = {
    primary: '#10b981',
    secondary: '#3b82f6',
    warning: '#f59e0b',
    danger: '#ef4444',
    purple: '#8b5cf6',
    pink: '#ec4899',
    teal: '#14b8a6',
    indigo: '#6366f1',
    orange: '#f97316',
    emerald: '#059669',
    cyan: '#06b6d4',
    violet: '#7c3aed',
    lime: '#84cc16',
    rose: '#f43f5e',
    amber: '#f59e0b',
    sky: '#0ea5e9'
};

const colorPalette = [
    '#10b981', // primary
    '#3b82f6', // secondary
    '#f59e0b', // warning
    '#ef4444', // danger
    '#8b5cf6', // purple
    '#ec4899', // pink
    '#14b8a6', // teal
    '#6366f1', // indigo
    '#f97316', // orange
    '#059669', // emerald
    '#06b6d4', // cyan
    '#7c3aed', // violet
    '#84cc16', // lime
    '#f43f5e', // rose
    '#0ea5e9', // sky
];

/**
 * Genera un array de colores del tamaño necesario
 * Si se necesitan más colores de los disponibles, genera variaciones
 */
function generarColores(cantidad) {
    if (cantidad <= colorPalette.length) {
        return colorPalette.slice(0, cantidad);
    }

    const colores = [...colorPalette];

    while (colores.length < cantidad) {
        const baseColor = colorPalette[colores.length % colorPalette.length];
        const variation = Math.floor((colores.length / colorPalette.length) * 30);
        colores.push(ajustarBrillo(baseColor, variation));
    }

    return colores;
}

/**
 * Ajusta el brillo de un color hexadecimal
 */
function ajustarBrillo(hex, percent) {
    const num = parseInt(hex.replace('#', ''), 16);
    let r = (num >> 16) + percent;
    let g = ((num >> 8) & 0x00FF) + percent;
    let b = (num & 0x0000FF) + percent;

    r = Math.max(0, Math.min(255, r));
    g = Math.max(0, Math.min(255, g));
    b = Math.max(0, Math.min(255, b));

    return '#' + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
}

/**
 * Genera colores con diferentes saturaciones para mayor variedad
 */
function generarColoresSaturacion(cantidad) {
    const hueStep = 360 / Math.max(cantidad, 12);
    const colores = [];

    for (let i = 0; i < cantidad; i++) {
        const hue = (i * hueStep) % 360;
        const saturation = 65 + (i % 3) * 10; // Variar saturación: 65%, 75%, 85%
        const lightness = 50 + (i % 2) * 10;  // Variar luminosidad: 50%, 60%
        colores.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
    }

    return colores;
}

const chartInstances = {};

function destroyChartIfExists(chartId) {
    if (chartInstances[chartId]) {
        chartInstances[chartId].destroy();
        delete chartInstances[chartId];
    }
}


function formatCurrency(value) {
    return '$' + (value / 1000000).toFixed(1) + 'M';
}

// Gráfico: Proyectos por Año
function crearGraficoProyectosPorAnio(data) {
    const ctx = document.getElementById('chartProyectosPorAnio');
    if (!ctx) return;

    destroyChartIfExists('chartProyectosPorAnio');

    chartInstances['chartProyectosPorAnio'] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(d => d.anio),
            datasets: [{
                label: 'Proyectos',
                data: data.map(d => d.proyectos),
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} proyectos`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 5,
                        precision: 0
                    }
                }
            }
        }
    });
}

// Gráfico: Distribución por Tipología
function crearGraficoTipologia(data) {
    const ctx = document.getElementById('chartTipologia');
    if (!ctx) return;

    destroyChartIfExists('chartTipologia');

    const chartColors = generarColoresSaturacion(data.length);

    chartInstances['chartTipologia'] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.map(d => d.name),
            datasets: [{
                data: data.map(d => d.value),
                backgroundColor: chartColors,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 11
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Gráfico: Proyectos por Procedencia
function crearGraficoProcedencia(data) {
    const ctx = document.getElementById('chartProcedencia');
    if (!ctx) return;

    destroyChartIfExists('chartProcedencia');

    const chartColors = data.length > 1 ? generarColores(data.length) : [colors.secondary];

    chartInstances['chartProcedencia'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.name),
            datasets: [{
                label: 'Proyectos',
                data: data.map(d => d.value),
                backgroundColor: chartColors,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.parsed.y} proyectos`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Gráfico: Proyectos por Programa
function crearGraficoProgramas(data) {
    const ctx = document.getElementById('chartProgramas');
    if (!ctx) return;

    destroyChartIfExists('chartProgramas');

    const chartColors = generarColores(data.length);

    chartInstances['chartProgramas'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.sufijo),
            datasets: [{
                label: 'Proyectos',
                data: data.map(d => d.proyectos),
                backgroundColor: chartColors,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return data[context[0].dataIndex].programa;
                        },
                        label: function(context) {
                            return `${context.parsed.x} proyectos`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Gráfico: Inversión por Programa
function crearGraficoInversion(data) {
    const ctx = document.getElementById('chartInversion');
    if (!ctx) return;

    destroyChartIfExists('chartInversion');

    chartInstances['chartInversion'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.sufijo),
            datasets: [{
                label: 'Inversión',
                data: data.map(d => d.costo),
                backgroundColor: colors.warning,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return formatCurrency(context.parsed.y);
                        },
                        title: function(context) {
                            return data[context[0].dataIndex].programa;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    }
                }
            }
        }
    });
}

// Gráfico: Productos por Tipo
function crearGraficoProductos(data) {
    const ctx = document.getElementById('chartProductos');
    if (!ctx) return;

    destroyChartIfExists('chartProductos');

    const chartColors = generarColores(data.length);

    chartInstances['chartProductos'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.map(d => d.tipo),
            datasets: [{
                label: 'Cantidad',
                data: data.map(d => d.cantidad),
                backgroundColor: chartColors,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} productos`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Gráfico: Evolución de Investigadores
function crearGraficoEvolucionInvestigadores(data) {
    const ctx = document.getElementById('chartEvolucionInvestigadores');
    if (!ctx) return;

    destroyChartIfExists('chartEvolucionInvestigadores');

    chartInstances['chartEvolucionInvestigadores'] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.map(d => d.mes),
            datasets: [
                {
                    label: 'Activos',
                    data: data.map(d => d.activos),
                    borderColor: colors.primary,
                    backgroundColor: colors.primary + '20',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Históricos',
                    data: data.map(d => d.historicos),
                    borderColor: colors.warning,
                    backgroundColor: colors.warning + '20',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Gráfico: Estado de Investigadores
function crearGraficoEstadoInvestigadores(activos, historicos, revinculados) {
    const ctx = document.getElementById('chartEstadoInvestigadores');
    if (!ctx) return;

    destroyChartIfExists('chartEstadoInvestigadores');

    const inactivos = historicos - revinculados;

    chartInstances['chartEstadoInvestigadores'] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Activos', 'Revinculados', 'Inactivos'],
            datasets: [{
                data: [activos, revinculados, inactivos],
                backgroundColor: [colors.primary, colors.secondary, colors.warning],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Gráfico: Archivos por Almacenamiento
function crearGraficoArchivos(cloudinary, local) {
    const ctx = document.getElementById('chartArchivos');
    if (!ctx) return;

    destroyChartIfExists('chartArchivos');

    chartInstances['chartArchivos'] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Cloudinary', 'Local'],
            datasets: [{
                data: [cloudinary, local],
                backgroundColor: [colors.primary, colors.warning],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} archivos (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Gráfico: Archivos por Entidad
function crearGraficoArchivosPorEntidad(proyectos, productos) {
    const ctx = document.getElementById('chartArchivosPorEntidad');
    if (!ctx) return;

    destroyChartIfExists('chartArchivosPorEntidad');

    chartInstances['chartArchivosPorEntidad'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Proyectos', 'Productos'],
            datasets: [{
                label: 'Archivos',
                data: [proyectos, productos],
                backgroundColor: [colors.secondary, colors.purple],
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.parsed.y} archivos`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

// Función para inicializar todos los gráficos
function initDashboardCharts(data) {
    if (data.proyectosPorAnio) {
        crearGraficoProyectosPorAnio(data.proyectosPorAnio);
    }
    if (data.proyectosPorTipologia) {
        crearGraficoTipologia(data.proyectosPorTipologia);
    }
    if (data.proyectosPorProcedencia) {
        crearGraficoProcedencia(data.proyectosPorProcedencia);
    }
}
