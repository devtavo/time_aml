L.drawLocal = {
    draw: {
        toolbar: {            
            actions: {
                title: 'Cancelar',
                text: 'Cancelar'
            },
            finish: {
                title: 'Finalizar',
                text: 'Finalizar'
            },
            undo: {
                title: 'Eliminar último punto',
                text: 'Eliminar último punto'
            },
            buttons: {
                polyline: '- your text-',
                polygon: 'Dibujar polígono',
                rectangle: '- your text-',
                circle: '- your text-',
                marker: '- your text-',
                circlemarker: '- your text-'
            }
        },
        handlers: {
            circle: {
                tooltip: {
                    start: '- your text-'
                },
                radius: '- your text-'
            },
            circlemarker: {
                tooltip: {
                    start: '- your text-.'
                }
            },
            marker: {
                tooltip: {
                    start: '- your text-.'
                }
            },
            polygon: {
                tooltip: {
                    start: 'Presione clic para empezar a dibujar.',
                    cont: 'Presione clic para continuar dibujando.',
                    end: 'Presione clic en el primer punto para terminar.'
                }
            },
            polyline: {
                error: '<strong>Error:</strong> los bordes de la forma no pueden cruzarse!',
                tooltip: {
                    start: 'Haga clic para comenzar a dibujar la línea.',
                    cont: 'Haga clic para continuar dibujando la línea.',
                    end: 'Haga clic en el último punto para terminar la línea.'
                }
            },
            rectangle: {
                tooltip: {
                    start: '- your text-.'
                }
            },
            simpleshape: {
                tooltip: {
                    end: 'Suelte el mouse para terminar de dibujar.'
                }
            }
        }
    },
    edit: {
        toolbar: {
            actions: {
                save: {
                    title: 'Guardar cambios',
                    text: 'Salvar'
                },
                cancel: {
                    title: 'Cancelar la edición, descarta todos los cambios',
                    text: 'Cancelar'
                },
                clearAll: {
                    title: 'Borrar todas las capas',
                    text: 'Limpiar todo'
                }
            },
            buttons: {
                edit: 'Editar capas',
                editDisabled: 'No hay capas para editar',
                remove: 'Eliminar capas',
                removeDisabled: 'No hay capas para eliminar'
            }
        },
        handlers: {
            edit: {
                tooltip: {
                    text: 'Arrastre tiradores o marcadores para editar características.',
                    subtext: 'Haga clic en cancelar para deshacer los cambios.'
                }
            },
            remove: {
                tooltip: {
                    text: 'Haga clic en la geometría a eliminar.'
                }
            }
        }
    }
};