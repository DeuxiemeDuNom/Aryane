set :conf_application,  "thaliemero"
set :conf_domain,       "213.186.33.203" #eentouch.fr 213.186.33.203 ou fausse 213.186.33.16
set :conf_user,         "eentouchax"
set :conf_password,     "KXyZ8TEFHeHU"
set :conf_deploy_to,    "www/aryane/"
set :conf_php_path,     "/usr/local/php5.6/bin/php"
#set :conf_shared,       "#{conf_deploy_to}shared/"

# ASSETIC AND CACHE
set :cache_warmup, false
set :assets_install, false
set :dump_assetic_assets, false
set :shared_files, false
set :shared_children, false
set :clear_controllers, false
set :create_symlink, false

set :application, "#{conf_application}"
set :domain,      "#{conf_domain}"
set :deploy_to,   "#{conf_deploy_to}"
set :app_path,    "app"
set :web_path,    "web"
set :php_bin,     "#{conf_php_path}"

set :deploy_via,    :copy
#set :copy_strategy, :export
set :scm,         :none
set :repository,  "."
set :local_repository, "."
set :branch, "master"

#set :shared_files,      ["app/config/parameters.yml"]
#set :shared_children,   [app_path + "/logs", web_path + "/uploads"]
set :use_composer, false
set :update_vendors, false

set :writable_dirs, [app_path + "/cache", app_path + "/logs"]
set :webserver_user, "www-data"
set :permission_method, :chown
set :use_set_permissions, true
	
set :model_manager, "doctrine"

set :interactive_mode, false

role :web,              domain                         # Your HTTP server, Apache/etc
role :app,              domain       # This may be the same as your `Web` server
role :db,              domain, :primary => true       # This may be the same as your `Web` server

# SSH Settings
set :user,           "#{conf_user}"
set :use_sudo,    false
set :password,          "#{conf_password}"
set :ssh_options, {:forward_agent => true} # Ne pas redemander le password
default_run_options[:pty] = true
set :keep_releases, 0

#def load_database_config(data, env)
#    read_parameters(data)['parameters']
#end

# ENFIN UN TRUC QUI MARCHE
after "deploy:setup" do
  origin_file = "app/config/parameters.yml"
  destination_file = shared_path + "/app/config/parameters.yml" # Notice the
  shared_path

  try_sudo "mkdir -p #{File.dirname(destination_file)}"
  top.upload(origin_file, destination_file)
end

after "deploy", "deploy:cleanup"

# Be more verbose by uncommenting the following line
logger.level = Logger::IMPORTANT
logger.level = Logger::INFO
logger.level = Logger::DEBUG
logger.level = Logger::TRACE
logger.level = Logger::MAX_LEVEL
