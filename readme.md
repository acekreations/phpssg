# PHP SSG

PHP SSG is a simple static site generator that utilizes PHP ability to output html as it's bases.

## Usage

To run a build you must have PHP installed and run `php build.php`.

All files should be within the `/src` directory.

Build files will be outputted in the `/build` directory.

## Ignore

Including an underscore at the beginning of a file will ignore the file during build and will not output the file. It does not stop another php file from using `include() or require()` it.

```
header.php // file will be built
_header.php // file will not be built
```
