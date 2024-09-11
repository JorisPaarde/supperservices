const SVGSprite = require('svg-sprite');
const fs = require('fs');
const path = require('path');

const dir = path.join(__dirname, 'resources/icons');
const spriter = new SVGSprite({
    mode: {
        symbol: {
            dest: 'dist/',
        },
    },
});

const formatBytes = (bytes) => {
    if (!bytes) return '0 Byte';

    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(1024));

    return `${(bytes / 1024 ** i).toPrecision(3)} ${sizes[i]}`;
};

const pluralize = (value, word) => `${value} ${value === 1 ? word : `${word}s`}`;

fs.readdir(dir, (err, files) => {
    const icons = files.filter((name) => path.extname(name) === '.svg');

    icons.forEach((name) => {
        const file = path.resolve(`${dir}/${name}`);

        spriter.add(file, name, fs.readFileSync(file));
    });

    spriter.compile((error, result) => {
        const stats = {
            files: 0,
            size: 0,
        };

        Object.keys(result).forEach((mode) => {
            Object.keys(result[mode]).forEach((type) => {
                fs.writeFileSync(result[mode][type].path, result[mode][type].contents);

                const stat = fs.statSync(result[mode][type].path);
                stats.files += 1;
                stats.size += stat.size;
            });
        });

        console.log(
            '\x1b[32m%s\x1b[0m',
            `Success: ${pluralize(icons.length, 'icon')}, ${pluralize(
                stats.files,
                'file',
            )}, ${formatBytes(stats.size)}`,
        );
    });
});
