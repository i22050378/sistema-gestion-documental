using Microsoft.EntityFrameworkCore;

namespace SistemaGestion.Models
{
    public class AppDbContext : DbContext
    {
        public AppDbContext(DbContextOptions<AppDbContext> options) : base(options)
        {
        }

        public DbSet<Usuario> Usuarios { get; set; }
        public DbSet<Documento> Documentos { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);

            // Configuración de tabla Usuarios
            modelBuilder.Entity<Usuario>(entity =>
            {
                entity.ToTable("Usuarios");
                entity.HasKey(e => e.IdUsuario);
                entity.Property(e => e.Rol)
                    .HasDefaultValue("Operario");
            });

            // Configuración de tabla Documentos
            modelBuilder.Entity<Documento>(entity =>
            {
                entity.ToTable("Documentos");
                entity.HasKey(e => e.IdDocumento);
                entity.Property(e => e.Estado)
                    .HasDefaultValue("Borrador");
                entity.HasOne(d => d.Creador)
                    .WithMany(u => u.Documentos)
                    .HasForeignKey(d => d.IdCreador);
            });
        }
    }
}