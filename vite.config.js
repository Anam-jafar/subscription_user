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
                "resources/assets/js/form-wizard-init.js",
                "resources/assets/js/leaflet.js",
            ],
            refresh: true,
            buildDirectory: "subscription/build",
        }),

        viteStaticCopy({
            targets: [
                {
                    src: [
                        "resources/assets/icon-fonts/",

                        "resources/assets/js/form-wizard.js",
                        "resources/assets/js/main.js",
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
