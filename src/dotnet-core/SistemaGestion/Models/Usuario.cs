using System.ComponentModel.DataAnnotations;

namespace SistemaGestion.Models
{
    public class Usuario
    {
        public int IdUsuario { get; set; }

        [Required]
        [StringLength(100)]
        public string Nombre { get; set; } = "";

        [Required]
        [StringLength(100)]
        public string Apellido { get; set; } = "";

        [Required]
        [EmailAddress]
        public string Email { get; set; } = "";

        [Required]
        public string PasswordHash { get; set; } = "";

        [Required]
        public string Rol { get; set; } = "Operario";

        public bool Activo { get; set; } = true;

        public DateTime FechaCreacion { get; set; } = DateTime.Now;

        public ICollection<Documento> Documentos { get; set; } = new List<Documento>();
    }
}