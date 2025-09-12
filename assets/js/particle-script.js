(function (engine) { "use strict"; $.fn.particles = function () { var _this = this; var baseId = "tsparticles"; var init = function init(options, callback) { _this.each(function (index, element) { if (element.id === undefined) { element.id = baseId + Math.floor(engine.getRandom() * 1e3) } engine.tsParticles.load({ id: element.id, options: options }).then(callback) }) }; var ajax = function ajax(jsonUrl, callback) { _this.each(function (index, element) { if (element.id === undefined) { element.id = baseId + Math.floor(engine.getRandom() * 1e3) } engine.tsParticles.load({ id: element.id, url: jsonUrl }).then(callback) }) }; return { init: init, ajax: ajax } } })(window);


(function ($) {
    $(document).ready(async function () {
        await loadFull(tsParticles);

        $("#tsparticles")
            .particles()
            .init(
                {
                    background: {
                        color: {
                            value: "#0d47a1",
                        },
                    },
                    fpsLimit: 120,
                    interactivity: {
                        events: {
                            onClick: {
                                enable: true,
                                mode: "push",
                            },
                            onHover: {
                                enable: true,
                                mode: "repulse",
                            },
                        },
                        modes: {
                            push: {
                                quantity: 4,
                            },
                            repulse: {
                                distance: 200,
                                duration: 0.4,
                            },
                        },
                    },
                    particles: {
                        color: {
                            value: "#ffffff",
                        },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.5,
                            width: 1,
                        },
                        move: {
                            direction: "none",
                            enable: true,
                            outModes: {
                                default: "bounce",
                            },
                            random: false,
                            speed: 6,
                            straight: false,
                        },
                        number: {
                            density: {
                                enable: true,
                            },
                            value: 80,
                        },
                        opacity: {
                            value: 0.5,
                        },
                        shape: {
                            type: "circle",
                        },
                        size: {
                            value: { min: 1, max: 5 },
                        },
                    },
                    detectRetina: true,
                },
                function (container) {
                    // container is the particles container where you can play/pause or stop/start.
                    // the container is already started, you don't need to start it manually.
                },
            );

        // or

        $("#tsparticles")
            .particles()
            .ajax("particles.json", function (container) {
                // container is the particles container where you can play/pause or stop/start.
                // the container is already started, you don't need to start it manually.
            });
    });
})(jQuery);