import sys
import os

SECRETS = [
    b"__CHANGE_ME_IN_ENV_LOCAL__",
    b"__CHANGE_ME_IN_ENV_LOCAL__"
]
PLACEHOLDER = b"__CHANGE_ME_IN_ENV_LOCAL__"

def clean_file(filepath):
    try:
        with open(filepath, "rb") as f:
            content = f.read()
            
        new_content = content
        for secret in SECRETS:
            new_content = new_content.replace(secret, PLACEHOLDER)
            
        if new_content != content:
            with open(filepath, "wb") as f:
                f.write(new_content)
    except Exception:
        pass

if __name__ == "__main__":
    for root, dirs, files in os.walk("."):
        if ".git" in root:
            continue
        for file in files:
            clean_file(os.path.join(root, file))
