FROM richarvey/nginx-php-fpm:1.9.0
LABEL maintainer="Patrick McCarren <patrick@clops.io>"

USER 0
EXPOSE 443 80

ADD . /app
RUN chmod 750 /app/.ci/build.sh && /app/.ci/build.sh

WORKDIR "/app"
ENTRYPOINT ["/app/.ci/start.sh"]
