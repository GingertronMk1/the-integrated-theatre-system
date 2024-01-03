FROM debian:12.4-slim

RUN apt-get -y update && apt-get -y install curl

RUN curl -L https://fly.io/install.sh | sh

RUN echo "export FLYCTL_INSTALL=\"/root/.fly\"" >> $HOME/.bash_profile \
    && echo 'export PATH="$FLYCTL_INSTALL/bin:$PATH"' >> $HOME/.bash_profile

WORKDIR /app

ENTRYPOINT ["tail", "-f", "/dev/null"]
