"""Run after node scripts/scope-css.cjs. Only runtime plugin files enter ZIP."""
from pathlib import Path
from zipfile import ZipFile, ZIP_DEFLATED

repo = Path(__file__).resolve().parents[1]
root = repo / 'wp-plugin'
files = sorted((root / 'annie-yahaya-site').rglob('*'))
target = repo / 'dist/annie-yahaya-site.zip'
target.parent.mkdir(exist_ok=True)
with ZipFile(target, 'w', ZIP_DEFLATED) as archive:
    for file in files:
        if file.is_file():
            archive.write(file, file.relative_to(root).as_posix())
with ZipFile(target) as archive:
    assert archive.testzip() is None
    for file in files:
        if file.is_file():
            assert archive.read(file.relative_to(root).as_posix()) == file.read_bytes()
    assert 'annie-yahaya-site/assets/elementor-resets.css' not in archive.namelist()
    print(f'Verified {len(archive.namelist())} files: {target}')
