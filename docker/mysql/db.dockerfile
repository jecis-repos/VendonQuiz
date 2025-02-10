FROM mysql:8.0.39-debian

RUN apt update && apt install -y \
    curl \
    g++ \
    fish    \
    pv \
