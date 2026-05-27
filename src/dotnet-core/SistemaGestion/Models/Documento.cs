using System.ComponentModel.DataAnnotations;

namespace SistemaGestion.Models
{
    public class Documento
    {
        public int IdDocumento { get; set; }

        [Required]
        [StringLength(200)]
        public string Titulo { get; set; } = "";

        public string? Descripcion { get; set; }

        [Required]
        public string TipoArchivo { get; set; } = "";

        [Required]
        public string RutaArchivo { get; set; } = "";

        public string Estado { get; set; } = "Borrador";

        public int Version { get; set; } = 1;

        public int? IdCreador { get; set; }

        public Usuario? Creador { get; set; }

        public DateTime FechaCreacion { get; set; } = DateTime.Now;

        public DateTime FechaActualizacion { get; set; } = DateTime.Now;
    }
}