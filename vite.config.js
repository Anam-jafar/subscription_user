import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";
import * as packages from "./package.json";
import fsExtra from "fs-extra"; // Import fs-extra as a default import
import { join } from "path";

export default defineConfig({
    plugins: [
        // Remove old public/build directory before building
        {
            name: "clean-public-build",
            buildStart() {
                if (fsExtra.existsSync("public/build")) {
                    fsExtra.removeSync("public/build");
                }
            },
        },
        laravel({
            input: [
                // Resources paths
                "resources/css/app.css",
                "resources/sass/app.scss",
                "resources/js/app.js",

                // Resources assets js file paths
                "resources/assets/js/apexcharts-area.js",
                "resources/assets/js/apexcharts-bar.js",
                "resources/assets/js/apexcharts-boxplot.js",
                "resources/assets/js/apexcharts-bubble.js",
                "resources/assets/js/apexcharts-candlestick.js",
                "resources/assets/js/apexcharts-column.js",
                "resources/assets/js/apexcharts-funnel.js",
                "resources/assets/js/apexcharts-heatmap.js",
                "resources/assets/js/apexcharts-line.js",
                "resources/assets/js/apexcharts-mixed.js",
                "resources/assets/js/apexcharts-pie.js",
                "resources/assets/js/apexcharts-polararea.js",
                "resources/assets/js/apexcharts-radar.js",
                "resources/assets/js/apexcharts-radialbar.js",
                "resources/assets/js/apexcharts-rangearea.js",
                "resources/assets/js/apexcharts-scatter.js",
                "resources/assets/js/apexcharts-slope.js",
                "resources/assets/js/apexcharts-timeline.js",
                "resources/assets/js/apexcharts-treemap.js",
                "resources/assets/js/chartjs-charts.js",
                "resources/assets/js/custom.js",
                "resources/assets/js/custom-switcher.js",
                "resources/assets/js/datatables.js",
                "resources/assets/js/date&time-pickers.js",
                "resources/assets/js/defaultmenu.js",
                "resources/assets/js/draggable-cards",
                "resources/assets/js/form-wizard-init.js",
                "resources/assets/js/echarts.js",
                "resources/assets/js/file-manager.js",
                "resources/assets/js/fileupload.js",
                "resources/assets/js/form-advanced.js",
                "resources/assets/js/form-input-mask.js",
                "resources/assets/js/form-validation.js",
                "resources/assets/js/grid.js",
                "resources/assets/js/leaflet.js",
                "resources/assets/js/mail-settings.js",
                "resources/assets/js/mail.js",
                "resources/assets/js/markup.js",
                "resources/assets/js/media-player.js",
                "resources/assets/js/modal.js",
                "resources/assets/js/prism-custom.js",
                "resources/assets/js/quill-editor.js",
                "resources/assets/js/search-results.js",
                "resources/assets/js/select.js",
                "resources/assets/js/select2.js",
                "resources/assets/js/simplebar.js",
                "resources/assets/js/sortable.js",
                "resources/assets/js/sweet-alerts.js",
                "resources/assets/js/swiper.js",
                "resources/assets/js/tagify.js",
                "resources/assets/js/toasts.js",
                "resources/assets/js/tom-select.js",
                "resources/assets/js/validation.js",
                "resources/assets/js/widgets.js",
            ],
            refresh: true,
            buildDirectory: "subscription/build",
        }),

        viteStaticCopy({
            targets: [
                {
                    src: [
                        "resources/assets/icon-fonts/",

                        "resources/assets/js/authentication-main.js",
                        "resources/assets/js/form-wizard.js",
                        "resources/assets/js/landing-sticky.js",
                        "resources/assets/js/main.js",
                        "resources/assets/js/markup.js",
                        "resources/assets/js/show-password.js",
                        "resources/assets/js/sticky.js",
                        "resources/assets/js/switch.js",
                        "resources/assets/js/two-step-verification.js",
                    ],
                    dest: "assets/",
                },
            ],
        }),

        {
            // Use a custom plugin for copying distribution files
            name: "copy-dist-files",
            writeBundle: async () => {
                const destDir = "public/subscription/build/assets/libs"; // Update the destination directory

                for (const dep of Object.keys(packages.dependencies)) {
                    const srcPath = join("node_modules", dep, "dist");
                    const destPath = join(destDir, dep);

                    // Check if the 'dist' directory exists for the dependency
                    if (await fsExtra.pathExists(srcPath)) {
                        // Copy the distribution files (contents of 'dist') to the destination directory
                        await fsExtra.copy(srcPath, destPath, {
                            overwrite: true,
                            recursive: true,
                        });

                        // Remove the 'dist' directory from the destination
                        await fsExtra.remove(join(destPath, "dist"));
                    } else {
                        // If 'dist' folder doesn't exist, check if the package itself exists and copy it.
                        const packageSrcPath = join("node_modules", dep);
                        const packageDestPath = join(destDir, dep);

                        if (await fsExtra.pathExists(packageSrcPath)) {
                            await fsExtra.copy(
                                packageSrcPath,
                                packageDestPath,
                                {
                                    overwrite: true,
                                    recursive: true,
                                }
                            );
                        }
                    }
                }
            },
        },

        {
            name: "blade",
            handleHotUpdate({ file, server }) {
                if (file.endsWith(".blade.php")) {
                    server.ws.send({
                        type: "full-reload",
                        path: "*",
                    });
                }
            },
        },
    ],

    css: {
        preprocessorOptions: {
            scss: {
                api: "modern-compiler",
            },
        },
    },
    build: {
        chunkSizeWarningLimit: 1600,
        outDir: "public/subscription/build",
        emptyOutDir: true,
    },
});
