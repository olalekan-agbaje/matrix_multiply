pipeline {
    agent {
        label 'vagrant'
    }
    stages {
        stage('Build + PHP Version'){
            steps {
                sh 'php --version'
            }
        }
        stage('Composer Install'){   
            steps{
                sh 'composer install'
            }
        }
        stage('Prepare env and Migrate DB'){
            steps{            
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
                sh 'cp .env .env.testing'
                sh 'touch database/database.sqlite'
                sh 'php artisan migrate'
            }
        }
        stage('Feature tests') {
            steps {
                sh 'php artisan test'
            }
        }
    }
}
